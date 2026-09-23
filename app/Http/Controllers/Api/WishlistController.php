<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\FormatsData;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use FormatsData;

    public function index(Request $request)
    {
        $user = $request->attributes->get('api_user');
        $items = Wishlist::with(['product.variants.media', 'product.category'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'items' => $items->filter(fn($w) => $w->product)->map(fn($w) => $this->fmtProduct($w->product))->values(),
        ]);
    }

    public function toggle(Request $request)
    {
        $user = $request->attributes->get('api_user');
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            Wishlist::create(['user_id' => $user->id, 'product_id' => $request->product_id, 'created_at' => now()]);
            $wishlisted = true;
        }

        return response()->json([
            'wishlisted' => $wishlisted,
            'count' => Wishlist::where('user_id', $user->id)->count(),
        ]);
    }
}
