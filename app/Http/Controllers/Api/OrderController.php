<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\FormatsData;
use App\Models\{Cart, Order, OrderItem, Setting, Coupon};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use FormatsData;

    private function getCart(Request $request): ?Cart
    {
        $user = $request->attributes->get('api_user');
        if ($user) {
            return Cart::where('user_id', $user->id)->first();
        }
        $sid = $request->header('X-Guest-Id') ?: $request->input('guest_id');
        return $sid ? Cart::where('session_id', $sid)->first() : null;
    }

    public function checkout(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'payment_method' => 'nullable|in:cod,card',
            'coupon_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        $cart = $this->getCart($request);
        if (!$cart || $cart->count() === 0) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        $cart->load(['items.product', 'items.variant']);
        $subtotal = $cart->total();

        $fee = (float) Setting::get('general.shipping_fee', 30);
        $freeAbove = (float) Setting::get('general.free_shipping_above', 500);
        if ($subtotal >= $freeAbove) {
            $fee = 0;
        }

        $discount = 0;
        $couponCode = null;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponCode = $coupon->code;
                $coupon->increment('used_count');
            }
        }

        $total = max(0, $subtotal + $fee - $discount);
        $ref = 'SV-' . date('Y') . '-' . strtoupper(Str::random(6));

        $user = $request->attributes->get('api_user');

        $order = Order::create([
            'ref_number' => $ref,
            'user_id' => $user?->id,
            'guest_name' => $request->name,
            'guest_email' => $request->email,
            'guest_phone' => $request->phone,
            'shipping_address' => $request->address,
            'shipping_city' => $request->city,
            'shipping_country' => $request->country ?? 'UAE',
            'subtotal' => $subtotal,
            'shipping_fee' => $fee,
            'discount' => $discount,
            'total' => $total,
            'coupon_code' => $couponCode,
            'payment_method' => $request->input('payment_method', 'cod'),
            'notes' => $request->notes,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'product_name' => $item->product?->name_en,
                'variant_name' => $item->variant?->name_en,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ]);
        }

        $cart->items()->delete();
        $cart->delete();

        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => $this->fmtOrder($order->load('items'), true),
        ], 201);
    }

    public function index(Request $request)
    {
        $user = $request->attributes->get('api_user');
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->paginate(10);

        return response()->json([
            'orders' => collect($orders->items())->map(fn($o) => $this->fmtOrder($o))->values(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function show(Request $request, string $ref)
    {
        $user = $request->attributes->get('api_user');
        $order = Order::with('items')->where('ref_number', $ref)->where('user_id', $user->id)->firstOrFail();
        return response()->json(['order' => $this->fmtOrder($order, true)]);
    }
}
