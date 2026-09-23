@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'إنشاء حساب':'Register')
@section('content')
@php $l=app()->getLocale(); @endphp
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
  <div class="sv-card">
    <h4 class="text-uppercase mb-4">{{ $l==='ar'?'إنشاء حساب':'Create Account' }}</h4>
    <form method="POST" action="{{ route('register.post') }}">
      @csrf
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'الاسم':'Name' }}</label><input name="name" class="sv-input" required></div>
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'البريد':'Email' }}</label><input name="email" type="email" class="sv-input" required></div>
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'كلمة المرور':'Password' }}</label><input name="password" type="password" class="sv-input" required></div>
      <div class="mb-3"><label class="sv-label">{{ $l==='ar'?'تأكيد كلمة المرور':'Confirm Password' }}</label><input name="password_confirmation" type="password" class="sv-input" required></div>
      <button class="btn btn-dark w-100 text-uppercase">{{ $l==='ar'?'إنشاء حساب':'Register' }}</button>
    </form>
    <p class="text-center mt-3" style="font-size:13px">{{ $l==='ar'?'لديك حساب؟':'Have an account?'}} <a href="{{ route('login') }}">{{ $l==='ar'?'تسجيل الدخول':'Login' }}</a></p>
  </div>
</div></div></div>
@endsection
