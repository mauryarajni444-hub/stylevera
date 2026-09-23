@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'طلباتي':'My Orders')
@section('content')
@php $l=app()->getLocale(); @endphp
<div class="container py-5">
  <h4 class="text-uppercase mb-4">{{ $l==='ar'?'طلباتي':'My Orders' }}</h4>
  @forelse($orders as $order)
  <div class="sv-card mb-3">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <strong>{{ $order->ref_number }}</strong>
        <small style="color:#999;display:block">{{ $order->created_at->format('d M Y') }}</small>
      </div>
      <div class="text-end">
        <span class="sv-badge sv-b-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        <div class="mt-1" style="font-weight:600">{{ number_format($order->total,2) }} AED</div>
      </div>
    </div>
  </div>
  @empty
  <p style="color:#999">{{ $l==='ar'?'لا توجد طلبات بعد.':'No orders yet.' }}</p>
  @endforelse
  {{ $orders->links() }}
</div>
@endsection
