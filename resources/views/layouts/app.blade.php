<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Stylevera — Dress Your Story')</title>
<meta name="description" content="@yield('meta_desc','Stylevera — Premium Fashion UAE. AED Pricing. Free Shipping above 500 AED.')">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&family=Marcellus&family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
<link href="{{ asset('css/kaira-base.css') }}" rel="stylesheet">
<link href="{{ asset('css/stylevera.css') }}" rel="stylesheet">
@stack('styles')
</head>
<body class="homepage">

{{-- SVG Symbols --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none"><defs>
<symbol id="heart" viewBox="0 0 24 24"><path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Z"/></symbol>
<symbol id="cart" viewBox="0 0 24 24"><path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545 1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/></symbol>
<symbol id="search" viewBox="0 0 24 24"><path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/></symbol>
<symbol id="user" viewBox="0 0 24 24"><path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.14-8.3ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z"/></symbol>
<symbol id="arrow-left" viewBox="0 0 24 24"><path fill="currentColor" d="M17 11H9.41l3.3-3.29a1 1 0 1 0-1.42-1.42l-5 5a1 1 0 0 0 0 1.42l5 5a1 1 0 0 0 1.42-1.42L9.41 13H17a1 1 0 0 0 0-2Z"/></symbol>
<symbol id="arrow-right" viewBox="0 0 24 24"><path fill="currentColor" d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 1.42 1.42l5-5a1 1 0 0 0 .21-1.09Z"/></symbol>
<symbol id="play" viewBox="0 0 24 24"><path fill="currentColor" d="M5.669 4.76a1.469 1.469 0 0 1 2.04-1.177c1.062.454 3.442 1.533 6.462 3.276c3.021 1.744 5.146 3.267 6.069 3.958c.788.591.79 1.763.001 2.356c-.914.687-3.013 2.19-6.07 3.956c-3.06 1.766-5.412 2.832-6.464 3.28c-.906.387-1.92-.2-2.038-1.177c-.138-1.142-.396-3.735-.396-7.237c0-3.5.257-6.092.396-7.235Z"/></symbol>
<symbol id="calendar" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="18" x="2" y="4" rx="4"/><path d="M8 2v4m8-4v4M2 10h20"/></g></symbol>
<symbol id="shopping-bag" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><path d="M3.977 9.84A2 2 0 0 1 5.971 8h12.058a2 2 0 0 1 1.994 1.84l.803 10A2 2 0 0 1 18.833 22H5.167a2 2 0 0 1-1.993-2.16l.803-10Z"/><path d="M16 11V6a4 4 0 0 0-4-4v0a4 4 0 0 0-4 4v5"/></g></symbol>
<symbol id="gift" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="14" x="3" y="8" rx="2"/><path d="M12 5a3 3 0 1 0-3 3m6 0a3 3 0 1 0-3-3m0 0v17m9-7H3"/></g></symbol>
<symbol id="arrow-cycle" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12c0 6-4.39 10-9.806 10C7.792 22 4.24 19.665 3 16m-1-4C2 6 6.39 2 11.806 2C16.209 2 19.76 4.335 21 8"/><path d="m7 17l-4-1l-1 4M17 7l4 1l1-4"/></g></symbol>
<symbol id="instagram" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M11 3.5h1M4.5.5h6a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4h-6a4 4 0 0 1-4-4v-6a4 4 0 0 1 4-4Zm3 10a3 3 0 1 1 0-6a3 3 0 0 1 0 6Z"/></symbol>
<symbol id="facebook" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="M7.5 14.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14Zm0 0v-8a2 2 0 0 1 2-2h.5m-5 4h5"/></symbol>
<symbol id="twitter" viewBox="0 0 15 15"><path fill="currentColor" d="M14.478 1.5l-.5.033-.371-.334a.5.5 0 0 1 .871.301Zm-.498 2.959a.5.5 0 1 1 1 0h-1Z"/></symbol>
<symbol id="pinterest" viewBox="0 0 15 15"><path fill="none" stroke="currentColor" d="m4.5 13.5l3-7m-3.236 3a3 3 0 0 1-.764-2V7A3.5 3.5 0 0 1 7 3.5h1A3.5 3.5 0 0 1 11.5 7v.5a3 3 0 0 1-3 3a2.081 2.081 0 0 1-1.974-1.423L6.5 9m1 5.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14Z"/></symbol>
<symbol id="star-solid" viewBox="0 0 15 15"><path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z"/></symbol>
</defs></svg>

<div class="preloader text-white fs-6 text-uppercase overflow-hidden"></div>

{{-- Announcement --}}
@php $ann = \App\Models\Setting::get('announcement_'.session('locale','en').'.text','Free Shipping above 500 AED | Use STYLEVERA10 for 10% off'); @endphp
<div class="sv-announcement"><span>{{ $ann }}</span><button class="sv-ann-close">✕</button></div>

{{-- Search Popup --}}
<div class="search-popup" style="height: 0"><div class="search-popup-container">
  <form action="{{ route('shop') }}" method="GET" class="form-group">
    <input type="search" name="search" class="form-control border-0 border-bottom" placeholder="{{ app()->getLocale()==='ar'?'اكتب للبحث...':'Type and press enter' }}">
    <button type="submit" class="search-submit border-0 position-absolute bg-white" style="top:15px;right:15px"><svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#search"/></svg></button>
  </form>
  <h5 class="cat-list-title">{{ app()->getLocale()==='ar'?'تصفح الفئات':'Browse Categories' }}</h5>
  <ul class="cat-list">
    @foreach(\App\Models\Category::where('is_active',1)->orderBy('sort_order')->take(7)->get() as $c)
    <li class="cat-list-item"><a href="{{ route('shop',['cat'=>$c->slug]) }}">{{ $c->nameLocale() }}</a></li>
    @endforeach
  </ul>
</div></div>

{{-- Cart Offcanvas --}}
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header justify-content-center"><button class="btn-close" data-bs-dismiss="offcanvas"></button></div>
    <div class="offcanvas-body">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>{{ app()->getLocale()==='ar'?'سلتك':'Your Cart' }}</span>
            <span class="badge rounded-pill sv-cart-badge" style="background:#8C907E">0</span>
        </h4>
        <div id="svCartItems"><div style="text-align:center;padding:48px 20px;color:#999"><i class="bi bi-bag" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:10px"></i>{{ app()->getLocale()==='ar'?'السلة فارغة':'Cart is empty' }}</div></div>
        <div class="mt-3 pt-3 border-top">
            <div class="d-flex justify-content-between fw-bold mb-3"><span>{{ app()->getLocale()==='ar'?'المجموع':'Total' }}</span><span id="svCartTotal">0.00 AED</span></div>
            <a href="{{ route('checkout') }}" class="btn btn-dark w-100 text-uppercase" style="letter-spacing:1.5px">{{ app()->getLocale()==='ar'?'إتمام الشراء':'Checkout' }}</a>
        </div>
    </div>
</div>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom align-items-center">
  <div class="container-fluid">
    <div class="row justify-content-between align-items-center w-100">
      <div class="col-auto">
        <a class="sv-navbar-brand" href="{{ route('home') }}">STYLEVERA</a>
      </div>
      <div class="col-auto">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav"><span class="navbar-toggler-icon"></span></button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav">
          <div class="offcanvas-header"><h5>Menu</h5><button class="btn-close" data-bs-dismiss="offcanvas"></button></div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 gap-md-4 pe-3">
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">{{ app()->getLocale()==='ar'?'الرئيسية':'Home' }}</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('shop')?'active':'' }}" href="#" data-bs-toggle="dropdown">{{ app()->getLocale()==='ar'?'المتجر':'Shop' }}</a>
                <ul class="dropdown-menu list-unstyled">
                  <li><a href="{{ route('shop') }}" class="dropdown-item">{{ app()->getLocale()==='ar'?'جميع المنتجات':'All Products' }}</a></li>
                  @foreach(\App\Models\Category::where('is_active',1)->orderBy('sort_order')->take(6)->get() as $c)
                  <li><a href="{{ route('shop',['cat'=>$c->slug]) }}" class="dropdown-item">{{ $c->nameLocale() }}</a></li>
                  @endforeach
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="{{ route('page.show','about') }}">{{ app()->getLocale()==='ar'?'من نحن':'About' }}</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ app()->getLocale()==='ar'?'اتصل بنا':'Contact' }}</a></li>
            </ul>
          </div>
        </div>
      </div>


      <div class="col-3 col-lg-auto">
        <ul class="list-unstyled d-flex align-items-center m-0 gap-2">
          <li class="d-none d-lg-block"><a href="{{ route('wishlist') }}" class="text-uppercase" style="font-size:13px;text-decoration:none;color:inherit">{{ app()->getLocale()==='ar'?'المفضلة':'Wishlist' }} <span class="wishlist-count">(0)</span></a></li>
          <li class="d-none d-lg-block"><a href="#" class="text-uppercase" style="font-size:13px;text-decoration:none;color:inherit" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">{{ app()->getLocale()==='ar'?'السلة':'Cart' }} <span class="cart-count">(0)</span></a></li>
          <li class="d-lg-none"><a href="{{ route('wishlist') }}"><svg width="22" height="22" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg></a></li>
          <li class="d-lg-none"><a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"><svg width="22" height="22" viewBox="0 0 24 24"><use xlink:href="#cart"/></svg></a></li>
          <li><a href="#search" class="search-button"><svg width="22" height="22" viewBox="0 0 24 24"><use xlink:href="#search"/></svg></a></li>
          @auth<li><a href="{{ route('account') }}"><svg width="22" height="22" viewBox="0 0 24 24"><use xlink:href="#user"/></svg></a></li>
          @else<li class="d-none d-lg-block"><a href="{{ route('login') }}" style="font-size:12px;text-decoration:none;color:inherit;letter-spacing:1px;text-transform:uppercase">{{ app()->getLocale()==='ar'?'دخول':'Login' }}</a></li>@endauth
          @if(app()->getLocale()==='ar')
            <li><a href="{{ route('lang.switch','en') }}" class="sv-lang-btn">EN</a></li>
          @else
            <li><a href="{{ route('lang.switch','ar') }}" class="sv-lang-btn" style="font-family:'Cairo',sans-serif">عربي</a></li>
          @endif
          <li><button class="sv-ctrl-btn" onclick="toggleMode()" title="Toggle dark mode"><i class="bi bi-moon" id="svModeIcon"></i></button></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

@if(session('success'))<div style="background:rgba(26,188,156,.08);border-left:4px solid #1abc9c;padding:11px 24px;font-size:13px;color:#0e7a60">✓ {{ session('success') }}</div>@endif
@if(session('error'))<div style="background:rgba(231,76,60,.08);border-left:4px solid #e74c3c;padding:11px 24px;font-size:13px;color:#922b21">{{ session('error') }}</div>@endif

@yield('content')

{{-- Newsletter --}}
<section class="newsletter bg-light" style="background-image:url('{{ asset('images/placeholder.svg') }}')">
  <div class="container"><div class="row justify-content-center"><div class="col-md-8 py-5 my-5">
    <div class="text-center pb-3"><h3 class="section-title text-uppercase" style="letter-spacing:2px">{{ app()->getLocale()==='ar'?'اشترك في نشرتنا':'Sign Up For Our Newsletter' }}</h3></div>
    <form id="svNewsletterForm" class="d-flex flex-wrap gap-2">
      <input type="email" name="email" placeholder="{{ app()->getLocale()==='ar'?'بريدك الإلكتروني':'Your Email Address' }}" class="form-control form-control-lg flex-grow-1" required>
      <button class="btn btn-dark btn-lg text-uppercase w-100" style="letter-spacing:2px">{{ app()->getLocale()==='ar'?'اشترك':'Sign Up' }}</button>
    </form>
  </div></div></div>
</section>

{{-- Instagram --}}
@php $ig = \App\Models\Setting::get('social.instagram','https://instagram.com/stylevera'); @endphp
<section class="instagram position-relative">
  <div class="d-flex justify-content-center w-100 position-absolute bottom-0 z-1">
    <a href="{{ $ig }}" target="_blank" class="btn btn-dark px-5" style="letter-spacing:1.5px">{{ app()->getLocale()==='ar'?'تابعنا على إنستغرام':'Follow Us On Instagram' }}</a>
  </div>
  <div class="row g-0">
    @php $instaImgs=[]; @endphp
    {{-- Instagram grid with placeholder --}}
    @for($n=1;$n<=6;$n++)
    <div class="col-6 col-sm-4 col-md-2">
      <div class="insta-item"><a href="{{ $ig }}" target="_blank"><img src="{{ asset('images/placeholder.svg') }}" alt="instagram" class="insta-image img-fluid" style="height:200px;object-fit:cover;filter:sepia(0.2)"></a></div>
    </div>
    @endfor
  </div>
</section>

{{-- Footer --}}
@php $s = \App\Models\Setting::all()->pluck('value','key'); @endphp
<footer id="footer" class="mt-5" style="background:var(--sv-footer);color:#aaa">
  <div class="container">
    <div class="row d-flex flex-wrap justify-content-between py-5">
      <div class="col-md-3 col-sm-6 mb-4">
        <a href="{{ route('home') }}" style="font-family:'Marcellus',serif;font-size:1.5rem;color:#f0f0f0;text-decoration:none;letter-spacing:.06em;display:block;margin-bottom:12px">STYLEVERA</a>
        <p style="font-size:13.5px;line-height:1.7;color:#666">{{ app()->getLocale()==='ar'?'وجهتك الأولى للأزياء الفاخرة في الإمارات العربية المتحدة.':'Your premier fashion destination in the UAE.' }}</p>
        <ul class="list-unstyled d-flex flex-wrap gap-3 mt-3">
          @foreach([['facebook',$s->get('social.facebook','#')],['instagram',$s->get('social.instagram','#')],['twitter',$s->get('social.twitter','#')],['pinterest',$s->get('social.pinterest','#')]] as [$icon,$url])
          <li><a href="{{ $url }}" target="_blank" style="color:#555;transition:color .2s" onmouseover="this.style.color='#8C907E'" onmouseout="this.style.color='#555'"><svg width="20" height="20" viewBox="0 0 24 24"><use xlink:href="#{{ $icon }}"/></svg></a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <h5 class="widget-title text-uppercase mb-4" style="font-size:11px;letter-spacing:2px;color:#f0f0f0">{{ app()->getLocale()==='ar'?'روابط سريعة':'Quick Links' }}</h5>
        <ul class="menu-list list-unstyled text-uppercase border-animation-left" style="font-size:12.5px">
          @foreach([['home','Home','الرئيسية'],['shop','Shop','المتجر'],['wishlist','Wishlist','المفضلة'],['contact','Contact','اتصل']] as [$r,$en,$ar])
          <li class="menu-item mb-2"><a href="{{ route($r) }}" class="item-anchor" style="color:#666;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#8C907E'" onmouseout="this.style.color='#666'">{{ app()->getLocale()==='ar'?$ar:$en }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <h5 class="widget-title text-uppercase mb-4" style="font-size:11px;letter-spacing:2px;color:#f0f0f0">{{ app()->getLocale()==='ar'?'مساعدة':'Help & Info' }}</h5>
        <ul class="menu-list list-unstyled text-uppercase border-animation-left" style="font-size:12.5px">
          @foreach([['page.show','returns','Returns','الإرجاع'],['page.show','privacy','Privacy','الخصوصية'],['page.show','terms','Terms','الشروط'],['page.show','about','About','من نحن']] as [$r,$p,$en,$ar])
          <li class="menu-item mb-2"><a href="{{ route($r,$p) }}" class="item-anchor" style="color:#666;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#8C907E'" onmouseout="this.style.color='#666'">{{ app()->getLocale()==='ar'?$ar:$en }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <h5 class="widget-title text-uppercase mb-4" style="font-size:11px;letter-spacing:2px;color:#f0f0f0">{{ app()->getLocale()==='ar'?'اتصل بنا':'Contact Us' }}</h5>
        <p style="font-size:13px;color:#666">{{ $s->get('general.address_en','Dubai Mall Area, Dubai, UAE') }}</p>
        <p style="font-size:13px"><a href="mailto:{{ $s->get('general.email','info@stylevera.com') }}" style="color:#8C907E">{{ $s->get('general.email','info@stylevera.com') }}</a></p>
        <p style="font-size:13px"><a href="tel:{{ $s->get('general.phone','+971 4 000 0000') }}" style="color:#8C907E">{{ $s->get('general.phone','+971 4 000 0000') }}</a></p>
      </div>
    </div>
  </div>
  <div style="border-top:1px solid #1a1a1a;padding:16px 0">
    <div class="container"><div class="row align-items-center">
      <div class="col-md-6"><p style="font-size:12px;color:#444;margin:0">© {{ date('Y') }} Stylevera. {{ app()->getLocale()==='ar'?'جميع الحقوق محفوظة.':'All rights reserved.' }}</p></div>
      <div class="col-md-6 text-end" style="font-size:12px;color:#444">{{ app()->getLocale()==='ar'?'طرق الدفع:':'Payment:' }} Visa · Mastercard · PayPal · Cash on Delivery</div>
    </div></div>
  </div>
</footer>

{{-- Lightbox --}}
<div class="sv-lightbox" id="svLightbox" onclick="if(event.target===this)svLightboxClose()">
  <button class="sv-lightbox-close" onclick="svLightboxClose()"><i class="bi bi-x-lg"></i></button>
  <img src="" alt="" style="display:none">
  <video controls style="display:none;max-width:90vw;max-height:90vh"></video>
</div>

<div id="svToastWrap" class="sv-toast-container"></div>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('js/script.min.js') }}"></script>
<script src="{{ asset('js/stylevera.js') }}"></script>

<style>
    .navbar,
    .dropdown,
    .dropdown-menu {
        position: relative;
        z-index: 99999 !important;
    }

    .dropdown-menu {
        z-index: 99999 !important;
    }
</style>

@stack('scripts')
</body>
</html>
