@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'اتصل بنا — ستايل فيرا':'Contact — Stylevera')
@section('content')
@php $locale=app()->getLocale(); @endphp
<div class="sv-breadcrumb"><div class="container"><a href="{{ route('home') }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a><span>/</span><strong>{{ $locale==='ar'?'اتصل بنا':'Contact' }}</strong></div></div>
<div class="container py-5">
  <div class="row g-5">
    <div class="col-lg-6">
      <h2 class="text-uppercase mb-4">{{ $locale==='ar'?'تواصل معنا':'Get In Touch' }}</h2>
      <form action="{{ route('contact.store') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-sm-6"><label class="sv-label">{{ $locale==='ar'?'الاسم':'Name' }}</label><input name="name" class="sv-input" required></div>
          <div class="col-sm-6"><label class="sv-label">{{ $locale==='ar'?'البريد':'Email' }}</label><input name="email" type="email" class="sv-input" required></div>
          <div class="col-12"><label class="sv-label">{{ $locale==='ar'?'الموضوع':'Subject' }}</label><input name="subject" class="sv-input"></div>
          <div class="col-12"><label class="sv-label">{{ $locale==='ar'?'الرسالة':'Message' }}</label><textarea name="message" rows="5" class="sv-input" required></textarea></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100">{{ $locale==='ar'?'إرسال':'Send Message' }}</button></div>
        </div>
      </form>
    </div>
    <div class="col-lg-6">
      <h4 class="text-uppercase mb-4">{{ $locale==='ar'?'معلومات التواصل':'Contact Info' }}</h4>
      <p>{{ $settings->get('general.address_en','Dubai Mall Area, Dubai, UAE') }}</p>
      <p><a href="mailto:{{ $settings->get('general.email','info@stylevera.com') }}">{{ $settings->get('general.email','info@stylevera.com') }}</a></p>
      <p><a href="tel:{{ $settings->get('general.phone','+971 4 000 0000') }}">{{ $settings->get('general.phone','+971 4 000 0000') }}</a></p>
    </div>
  </div>
</div>
@endsection
