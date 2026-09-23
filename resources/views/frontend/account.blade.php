@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'حسابي':'My Account')
@section('content')
@php $l=app()->getLocale(); @endphp
<div class="container py-5">
  <div class="row"><div class="col-md-8 mx-auto">
    <div class="sv-card">
      <h4 class="text-uppercase mb-4">{{ $l==='ar'?'مرحباً,':'Hello,' }} {{ $user->name }}</h4>
      <p>{{ $user->email }}</p>
      <div class="d-flex gap-3 mt-4">
        <a href="{{ route('account.orders') }}" class="btn btn-dark text-uppercase">{{ $l==='ar'?'طلباتي':'My Orders' }}</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-dark text-uppercase">{{ $l==='ar'?'تسجيل الخروج':'Logout' }}</button></form>
      </div>
    </div>
  </div></div>
</div>
@endsection
