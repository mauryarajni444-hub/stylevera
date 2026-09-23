@extends('layouts.app')
@section('title',$page->titleLocale().' — Stylevera')
@section('content')
<div class="sv-breadcrumb"><div class="container"><a href="{{ route('home') }}">{{ app()->getLocale()==='ar'?'الرئيسية':'Home' }}</a><span>/</span><strong>{{ $page->titleLocale() }}</strong></div></div>
<div class="container py-5"><div class="row justify-content-center"><div class="col-lg-8">{!! $page->contentLocale() !!}</div></div></div>
@endsection
