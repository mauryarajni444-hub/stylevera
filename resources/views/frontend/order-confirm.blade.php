@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'تأكيد الطلب':'Order Confirmed')
@section('content')
@php $locale=app()->getLocale(); @endphp
<div class="container py-5 text-center">
  <div style="max-width:600px;margin:0 auto">
    <div style="width:80px;height:80px;background:#27ae60;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2rem;color:#fff">✓</div>
    <h2 class="text-uppercase">{{ $locale==='ar'?'شكراً! تم استلام طلبك':'Thank You! Order Received' }}</h2>
    <p style="color:#999;margin:12px 0 24px">{{ $locale==='ar'?'رقم الطلب:':'Order Reference:' }} <strong style="color:var(--sv-text)">{{ $order->ref_number }}</strong></p>
    <div class="sv-card text-start mb-4">
      @foreach($order->items as $item)
      <div class="d-flex justify-content-between mb-2" style="font-size:13px">
        <span>{{ $item->product_name }} @if($item->variant_name)<small style="color:#999"> / {{ $item->variant_name }}</small>@endif × {{ $item->quantity }}</span>
        <span>{{ number_format($item->total,2) }} AED</span>
      </div>
      @endforeach
      <hr>
      <div class="d-flex justify-content-between fw-bold"><span>{{ $locale==='ar'?'الإجمالي':'Total' }}</span><span>{{ number_format($order->total,2) }} AED</span></div>
    </div>
    <a href="{{ route('home') }}" class="btn btn-dark text-uppercase me-2">{{ $locale==='ar'?'الرئيسية':'Home' }}</a>
    <a href="{{ route('shop') }}" class="btn btn-outline-dark text-uppercase">{{ $locale==='ar'?'تسوق مجدداً':'Continue Shopping' }}</a>
  </div>
</div>
@endsection
