<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Cart, CartItem, Product, ProductVariant, Coupon};
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(Request $request): Cart
    {
        $user = $request->attributes->get('api_user');
        if ($user) {
            return Cart::firstOrCreate(['user_id' => $user->id]);
        }
        $sid = $request->header('X-Guest-Id') ?: $request->input('guest_id');
        $sid = $sid ?: 'guest_' . uniqid();
        return Cart::firstOrCreate(['session_id' => $sid]);
    }

    private function payload(Cart $cart, ?float $discount = null): array
    {
        $cart->load(['items.product', 'items.variant.media']);
        $items = $cart->items->map(function ($item) {
            $media = $item->variant?->media?->first();
            return [
                'item_id' => $item->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'name' => $item->product?->nameLocale(),
                'variant_name' => $item->variant?->nameLocale(),
                'color' => $item->variant?->color,
                'size' => $item->variant?->size,
                'image' => $media?->url ?? $item->product?->cover_image,
                'price' => (float) $item->price,
                'quantity' => $item->quantity,
                'line_total' => (float) $item->price * $item->quantity,
            ];
        })->values();

        return [
            'items' => $items,
            'subtotal' => (float) $cart->total(),
            'discount' => $discount ?? 0,
            'count' => $cart->count(),
        ];
    }

    public function show(Request $request)
    {
        return response()->json($this->payload($this->getCart($request)));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::find($request->variant_id) : $product->variants()->first();
        $price = $variant ? ($variant->sale_price ?? $variant->price) : ($product->sale_price ?? $product->base_price);

        $cart = $this->getCart($request);
        $item = $cart->items()->where('product_id', $request->product_id)->where('variant_id', $request->variant_id)->first();

        if ($item) {
            $item->increment('quantity', $request->input('quantity', 1));
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->input('quantity', 1),
                'price' => $price,
            ]);
        }

        return response()->json(array_merge(['message' => 'Added to cart'], $this->payload($cart)));
    }

    public function update(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        if ($request->action === 'inc') {
            $item->increment('quantity');
        } elseif ($request->action === 'dec') {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                $item->delete();
            }
        } elseif ($request->filled('quantity')) {
            $item->update(['quantity' => max(1, (int) $request->quantity)]);
        }

        return response()->json($this->payload($this->getCart($request)));
    }

    public function remove(Request $request)
    {
        CartItem::where('id', $request->item_id)->delete();
        return response()->json($this->payload($this->getCart($request)));
    }

    public function clear(Request $request)
    {
        $cart = $this->getCart($request);
        $cart->items()->delete();
        return response()->json($this->payload($cart));
    }

    public function coupon(Request $request)
    {
        $coupon = Coupon::where('code', strtoupper($request->code))->first();
        if (!$coupon || !$coupon->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.'], 422);
        }

        $cart = $this->getCart($request);
        $subtotal = $cart->total();
        if ($subtotal < $coupon->min_order) {
            return response()->json(['success' => false, 'message' => 'Minimum order of ' . number_format($coupon->min_order, 2) . ' AED required.'], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json(array_merge([
            'success' => true,
            'message' => 'Coupon applied!',
            'coupon_code' => $coupon->code,
        ], $this->payload($cart, $discount)));
    }
}
