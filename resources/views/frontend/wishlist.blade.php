@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'المفضلة — ستايل فيرا':'Wishlist — Stylevera')
@section('content')
@php $locale=app()->getLocale(); @endphp
<div class="sv-breadcrumb"><div class="container"><a href="{{ route('home') }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a><span>/</span><strong>{{ $locale==='ar'?'المفضلة':'Wishlist' }}</strong></div></div>
<div class="container py-5">
  <h2 class="text-uppercase mb-5">{{ $locale==='ar'?'المفضلة':'Wishlist' }}</h2>
  @if($items->count())
  <div class="row g-4">
    @foreach($items as $item)
    @if($item->product)
    @php $p=$item->product; $dp=$p->getDisplayPrice(); @endphp
    <div class="col-md-4 col-6">
      <div class="product-item image-zoom-effect link-effect">
        <div class="image-holder position-relative">
          <a href="{{ route('product.show',$p->slug) }}"><img src="{{ asset($p->getCoverImage()) }}" alt="{{ $p->nameLocale() }}" class="product-image img-fluid"></a>
          <a href="#" class="btn-icon btn-wishlist wishlisted" onclick="svToggleWishlist({{ $p->id }},this);return false"><svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"></use></svg></a>
          <div class="product-content">
            <h5 class="text-uppercase fs-5 mt-3"><a href="{{ route('product.show',$p->slug) }}">{{ $p->nameLocale() }}</a></h5>
            <a href="{{ route('product.show',$p->slug) }}" class="text-decoration-none"><span class="price-aed">{{ number_format($dp['sale']??$dp['price'],2) }} AED</span></a>
          </div>
        </div>
      </div>
    </div>
    @endif
    @endforeach
  </div>
  @else
  <div class="text-center py-5"><p style="color:#999">{{ $locale==='ar'?'لا توجد منتجات في المفضلة.':'Your wishlist is empty.' }}</p><a href="{{ route('shop') }}" class="btn btn-dark text-uppercase">{{ $locale==='ar'?'تسوق الآن':'Shop Now' }}</a></div>
  @endif
</div>
@endsection
