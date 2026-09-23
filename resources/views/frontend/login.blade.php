@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'تسجيل الدخول':'Login')
@section('content')
@php $l=app()->getLocale(); @endphp
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
  <div class="sv-card">
    <h4 class="text-uppercase mb-4">{{ $l==='ar'?'تسجيل الدخول':'Login' }}</h4>
    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'البريد الإلكتروني':'Email' }}</label><input name="email" type="email" class="sv-input" required></div>
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'كلمة المرور':'Password' }}</label><input name="password" type="password" class="sv-input" required></div>
      <button class="btn btn-dark w-100 text-uppercase">{{ $l==='ar'?'دخول':'Login' }}</button>
    </form>
    <p class="text-center mt-3" style="font-size:13px">{{ $l==='ar'?'ليس لديك حساب؟':'No account?'}} <a href="{{ route('register') }}">{{ $l==='ar'?'سجل الآن':'Register</a>' }}</p>
  </div>
</div></div></div>
@endsection
