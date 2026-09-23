@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'تفاصيل الطلب':'Order Detail')
@section('content')
@php $l=app()->getLocale(); @endphp
<div class="container py-5">
  <h4 class="text-uppercase mb-1">{{ $l==='ar'?'الطلب رقم:':'Order:' }} {{ $order->ref_number }}</h4>
  <p style="color:#999;font-size:13px;margin-bottom:24px">{{ $order->created_at->format('d M Y') }}</p>
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="sv-card">
        @foreach($order->items as $item)
        <div class="d-flex justify-content-between mb-2" style="font-size:13px;padding-bottom:8px;border-bottom:1px solid var(--sv-border)">
          <span>{{ $item->product_name }} @if($item->variant_name)<small style="color:#999"> / {{ $item->variant_name }}</small>@endif × {{ $item->quantity }}</span>
          <span>{{ number_format($item->total,2) }} AED</span>
        </div>
        @endforeach
        <div class="d-flex justify-content-between fw-bold mt-3"><span>{{ $l==='ar'?'الإجمالي':'Total' }}</span><span>{{ number_format($order->total,2) }} AED</span></div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="sv-card">
        <div style="font-size:12px;color:#999;margin-bottom:8px">{{ $l==='ar'?'الحالة:':'Status:' }}</div>
        <span class="sv-badge sv-b-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        <div class="mt-3 pt-3 border-top" style="font-size:12px;color:#999">
          <div>{{ $order->shipping_address }}</div>
          <div>{{ $order->shipping_city }}, {{ $order->shipping_country }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-3"><a href="{{ route('account.orders') }}" class="btn btn-outline-dark text-uppercase" style="font-size:12px">← {{ $l==='ar'?'العودة':'Back to Orders' }}</a></div>
</div>
@endsection
