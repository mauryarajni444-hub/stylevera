@extends('layouts.admin')
@section('title','Order: '.$order->ref_number)
@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="sv-card mb-4">
      <div class="sv-card-title">Order Items</div>
      <table class="sv-table">
        <thead><tr><th>Product</th><th>Variant</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
        <tbody>@foreach($order->items as $i)
        <tr><td>{{ $i->product_name }}</td><td>{{ $i->variant_name }}</td><td>{{ $i->quantity }}</td><td>{{ number_format($i->price,2) }} AED</td><td><strong>{{ number_format($i->total,2) }} AED</strong></td></tr>
        @endforeach</tbody>
      </table>
      <div style="text-align:right;padding:12px;border-top:1px solid #eee">
        <div>Subtotal: {{ number_format($order->subtotal,2) }} AED</div>
        <div>Shipping: {{ number_format($order->shipping_fee,2) }} AED</div>
        @if($order->discount)<div>Discount: -{{ number_format($order->discount,2) }} AED</div>@endif
        <div style="font-weight:700;font-size:1.1rem;margin-top:8px">Total: {{ number_format($order->total,2) }} AED</div>
      </div>
    </div>
    <div class="sv-card">
      <div class="sv-card-title">Update Status</div>
      <form method="POST" action="{{ route('admin.orders.status',$order->id) }}">
        @csrf
        <div class="row g-3">
          <div class="col-md-6"><select name="status" class="admin-select">@foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)<option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
          <div class="col-md-6"><button class="btn btn-dark text-uppercase w-100" style="font-size:12px">Update Status</button></div>
          <div class="col-12"><label class="admin-label">Admin Notes</label><textarea name="admin_notes" class="admin-input" rows="3">{{ $order->admin_notes }}</textarea></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="sv-card">
      <div class="sv-card-title">Customer</div>
      <p><strong>{{ $order->guest_name }}</strong></p>
      <p style="color:#999">{{ $order->guest_email }}</p>
      <p style="color:#999">{{ $order->guest_phone }}</p>
      <hr>
      <p style="font-size:12px"><strong>Address:</strong><br>{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_country }}</p>
      @if($order->notes)<hr><p style="font-size:12px"><strong>Notes:</strong> {{ $order->notes }}</p>@endif
    </div>
  </div>
</div>
@endsection