<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') — Stylevera</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&family=Marcellus&display=swap" rel="stylesheet">
<link href="{{ asset('css/stylevera.css') }}" rel="stylesheet">
<style>
body{font-family:'Jost',sans-serif;background:#f8f8f8;color:#333;font-size:13.5px}
.upload-zone{border:2px dashed #ddd;padding:20px;text-align:center;cursor:pointer;border-radius:6px;transition:all .3s;color:#999}
.upload-zone:hover{border-color:#8C907E}
.admin-input{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:4px;font-size:13.5px;outline:none;background:#fff;color:#333;transition:border-color .2s}
.admin-input:focus{border-color:#8C907E;box-shadow:0 0 0 3px rgba(140,144,126,.12)}
.admin-label{font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#888;display:block;margin-bottom:5px}
.admin-select{width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:4px;font-size:13.5px;background:#fff;color:#333}
</style>
@stack('styles')
</head>
<body>
<div class="sv-admin-wrapper">
  {{-- Sidebar --}}
  <aside class="sv-sidebar">
    <div class="sv-sidebar-brand">
      <div class="sv-brand-name">STYLEVERA</div>
      <div class="sv-brand-sub">Admin Panel</div>
    </div>
    <div class="sv-nav-section">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="sv-nav-link {{ request()->routeIs('admin.dashboard')?'active':'' }}"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="{{ route('admin.orders.index') }}" class="sv-nav-link {{ request()->routeIs('admin.orders*')?'active':'' }}"><i class="bi bi-bag"></i> Orders @php $pend=\App\Models\Order::where('status','pending')->count(); @endphp @if($pend)<span class="sv-nav-badge">{{ $pend }}</span>@endif</a>
    <div class="sv-nav-section">Catalogue</div>
    <a href="{{ route('admin.products.index') }}" class="sv-nav-link {{ request()->routeIs('admin.products*')?'active':'' }}"><i class="bi bi-tag"></i> Products</a>
    <a href="{{ route('admin.categories.index') }}" class="sv-nav-link {{ request()->routeIs('admin.categories*')?'active':'' }}"><i class="bi bi-folder"></i> Categories</a>
    <a href="{{ route('admin.banners.index') }}" class="sv-nav-link {{ request()->routeIs('admin.banners*')?'active':'' }}"><i class="bi bi-image"></i> Banners</a>
    <a href="{{ route('admin.coupons.index') }}" class="sv-nav-link {{ request()->routeIs('admin.coupons*')?'active':'' }}"><i class="bi bi-ticket-perforated"></i> Coupons</a>
    <div class="sv-nav-section">CRM</div>
    <a href="{{ route('admin.contacts.index') }}" class="sv-nav-link {{ request()->routeIs('admin.contacts*')?'active':'' }}"><i class="bi bi-envelope"></i> Contacts</a>
    @if(auth()->user()->isMaster())
    <div class="sv-nav-section">System</div>
    <a href="{{ route('admin.users.index') }}" class="sv-nav-link {{ request()->routeIs('admin.users*')?'active':'' }}"><i class="bi bi-people"></i> Users</a>
    @endif
    <a href="{{ route('admin.settings') }}" class="sv-nav-link {{ request()->routeIs('admin.settings')?'active':'' }}"><i class="bi bi-gear"></i> Settings</a>
    <div class="sv-nav-section">Store</div>
    <a href="{{ route('home') }}" target="_blank" class="sv-nav-link"><i class="bi bi-box-arrow-up-right"></i> View Store</a>
    <form method="POST" action="{{ route('admin.logout') }}" style="padding:4px 20px">
      @csrf<button type="submit" class="sv-nav-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:10px 0"><i class="bi bi-box-arrow-left"></i> Logout</button>
    </form>
  </aside>

  {{-- Main --}}
  <div class="sv-admin-main">
    <div class="sv-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="d-lg-none btn btn-sm btn-light" onclick="svToggleSidebar()"><i class="bi bi-list"></i></button>
        <h6 style="margin:0;font-weight:700">@yield('title','Dashboard')</h6>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span style="font-size:12px;color:#999"><i class="bi bi-person"></i> {{ auth()->user()->name }}</span>
        <span class="sv-badge sv-b-active">{{ ucfirst(auth()->user()->role) }}</span>
      </div>
    </div>
    <div class="sv-admin-content">
      @if(session('success'))<div style="background:rgba(39,174,96,.1);border-left:4px solid #27ae60;padding:10px 16px;font-size:13px;color:#1a5e35;margin-bottom:16px;border-radius:4px">{{ session('success') }}</div>@endif
      @if(session('error'))<div style="background:rgba(231,76,60,.1);border-left:4px solid #e74c3c;padding:10px 16px;font-size:13px;color:#7b241c;margin-bottom:16px;border-radius:4px">{{ session('error') }}</div>@endif
      @yield('content')
    </div>
  </div>
</div>

<div id="svToastWrap" class="sv-toast-container"></div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/stylevera.js') }}"></script>
@stack('scripts')
</body></html>
