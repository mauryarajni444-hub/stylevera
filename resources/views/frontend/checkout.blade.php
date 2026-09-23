@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'الدفع — ستايل فيرا':'Checkout — Stylevera')
@push('styles')
    <style>
        /* ═══════════════════════════════════════════════════════
           STYLEVERA CHECKOUT — Premium Payment UI
           Dark/Light adaptive · Card flip · Live validation
        ═══════════════════════════════════════════════════════ */

        /* Payment method toggle */
        .sv-pay-methods { display:flex; gap:12px; margin-bottom:28px; }
        .sv-pay-btn {
            flex:1; padding:14px 10px; border-radius:10px; cursor:pointer;
            border:2px solid var(--sv-border); background:var(--sv-card);
            display:flex; flex-direction:column; align-items:center; gap:6px;
            transition:all .25s; color:var(--sv-muted); font-size:12px;
            font-weight:600; letter-spacing:.5px; text-transform:uppercase;
        }
        .sv-pay-btn i { font-size:1.5rem; }
        .sv-pay-btn:hover { border-color:var(--sv-primary); color:var(--sv-text); }
        .sv-pay-btn.active {
            border-color:#3a7bd5; background:rgba(58,123,213,.08);
            color:#3a7bd5; box-shadow:0 0 0 3px rgba(58,123,213,.12);
        }
        body.dark-mode .sv-pay-btn { background:#111; }
        body.dark-mode .sv-pay-btn.active { background:rgba(58,123,213,.12); }

        /* ── 3D CARD FLIP ── */
        .sv-card-scene {
            width:100%; max-width:420px; height:240px;
            perspective:1200px; margin:0 auto 28px;
        }
        .sv-card-3d {
            width:100%; height:100%; position:relative;
            transform-style:preserve-3d; transition:transform .7s cubic-bezier(.4,0,.2,1);
        }
        .sv-card-3d.is-flipped { transform:rotateY(180deg); }
        .sv-card-face {
            position:absolute; inset:0; border-radius:18px;
            backface-visibility:hidden; overflow:hidden;
            box-shadow:0 25px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.08);
        }
        /* Front */
        .sv-card-front {
            background:linear-gradient(135deg,#0f1b3d 0%,#1a3565 40%,#0d2b6b 70%,#1a1a3e 100%);
        }
        .sv-card-front::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(ellipse at 30% 50%, rgba(255,255,255,0.06) 0%,transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(58,123,213,0.15) 0%,transparent 50%);
        }
        /* Back */
        .sv-card-back {
            background:linear-gradient(135deg,#0d2052 0%,#1a3565 60%,#0f1b3d 100%);
            transform:rotateY(180deg);
        }
        .sv-card-back::before {
            content:''; position:absolute; top:40px; left:0; right:0; height:48px;
            background:#0a0a0a;
        }
        /* Card chip */
        .sv-card-chip {
            position:absolute; top:52px; left:28px; width:48px; height:36px;
            background:linear-gradient(135deg,#d4a843 0%,#f0c84a 40%,#b8922e 100%);
            border-radius:6px; overflow:hidden;
        }
        .sv-card-chip::before {
            content:''; position:absolute; top:50%; left:0; right:0; height:1.5px;
            background:rgba(100,70,0,.4); transform:translateY(-50%);
        }
        .sv-card-chip::after {
            content:''; position:absolute; top:0; bottom:0; left:50%;
            width:1.5px; background:rgba(100,70,0,.4); transform:translateX(-50%);
        }
        /* Visa / MasterCard logo */
        .sv-card-logo {
            position:absolute; top:26px; right:28px;
            font-size:26px; font-weight:900; font-style:italic;
            letter-spacing:-1px; color:#fff;
            text-shadow:0 2px 8px rgba(0,0,0,0.3);
        }
        .sv-card-logo .visa-v { color:#fff; }
        .sv-card-logo .visa-isa { color:#fff; }
        .sv-card-logo-mc {
            position:absolute; top:22px; right:24px;
            display:flex; gap:-8px;
        }
        .sv-mc-left  { width:36px; height:36px; border-radius:50%; background:rgba(235,0,27,0.9); }
        .sv-mc-right { width:36px; height:36px; border-radius:50%; background:rgba(255,160,0,0.9); margin-left:-14px; }
        /* Card number */
        .sv-card-number {
            position:absolute; bottom:68px; left:28px; right:28px;
            font-size:20px; font-weight:600; letter-spacing:4px; color:#fff;
            font-family:'Courier New',monospace; text-shadow:0 1px 4px rgba(0,0,0,0.4);
        }
        /* Card name */
        .sv-card-name {
            position:absolute; bottom:30px; left:28px;
            font-size:13.5px; font-weight:600; letter-spacing:2px; color:rgba(255,255,255,.9);
            text-transform:uppercase; font-family:'Jost',sans-serif;
        }
        /* Card expiry */
        .sv-card-expiry {
            position:absolute; bottom:30px; right:90px;
            text-align:center;
        }
        .sv-card-expiry .sv-cf-label { font-size:8px; letter-spacing:1px; color:rgba(255,255,255,.5); text-transform:uppercase; }
        .sv-card-expiry .sv-cf-val { font-size:13px; font-weight:600; color:#fff; font-family:'Courier New',monospace; }
        /* NFC icon */
        .sv-card-nfc {
            position:absolute; top:52px; right:28px;
            width:28px; height:28px; opacity:.6;
        }
        /* Back CVV */
        .sv-card-cvv-strip {
            position:absolute; top:100px; right:0; left:0; padding:0 28px;
        }
        .sv-card-cvv-bar {
            background:rgba(255,255,255,.12); border-radius:4px;
            padding:8px 14px; text-align:right;
            font-family:'Courier New',monospace; font-size:15px;
            color:#fff; font-weight:600; letter-spacing:4px;
            position:relative;
        }
        .sv-card-cvv-bar::before {
            content:'CVV'; position:absolute; left:14px; top:50%; transform:translateY(-50%);
            font-size:11px; letter-spacing:2px; color:rgba(255,255,255,.5); font-family:'Jost',sans-serif;
        }
        /* Hologram shimmer on card */
        .sv-card-holo {
            position:absolute; bottom:12px; right:22px;
            width:44px; height:36px; border-radius:6px;
            background:linear-gradient(135deg, rgba(255,255,255,.05), rgba(100,200,255,.1), rgba(255,255,255,.05));
            border:1px solid rgba(255,255,255,.12);
            animation:holoShimmer 3s ease-in-out infinite;
        }
        @keyframes holoShimmer {
            0%,100%{ background:linear-gradient(135deg,rgba(255,200,100,.06),rgba(100,200,255,.1),rgba(200,100,255,.06)); }
            50%{ background:linear-gradient(135deg,rgba(100,200,255,.1),rgba(200,100,255,.08),rgba(255,200,100,.08)); }
        }

        /* ── PAYMENT DETAILS PANEL ── */
        .sv-pay-panel {
            background:var(--sv-card); border:1.5px solid var(--sv-border);
            border-radius:14px; overflow:hidden;
        }
        body.dark-mode .sv-pay-panel { background:#0e1117; border-color:#1e2535; }
        .sv-pay-panel-header {
            padding:20px 24px 16px; border-bottom:1px solid var(--sv-border);
            display:flex; justify-content:space-between; align-items:center;
        }
        body.dark-mode .sv-pay-panel-header { border-color:#1e2535; }
        .sv-pay-panel-title { font-size:18px; font-weight:700; color:var(--sv-text); }
        .sv-secure-badge {
            width:38px; height:38px; border-radius:50%;
            background:linear-gradient(135deg,#1a5abb,#3a8bd5);
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:16px; box-shadow:0 4px 12px rgba(26,90,187,.4);
        }
        .sv-pay-panel-body { padding:22px 24px; }
        .sv-pay-row { padding:14px 0; border-bottom:1px solid var(--sv-border); }
        body.dark-mode .sv-pay-row { border-color:#1e2535; }
        .sv-pay-row:last-child { border-bottom:none; }
        .sv-pay-row-label { font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#3a7bd5; margin-bottom:6px; }
        .sv-pay-row-val { font-size:17px; font-weight:600; color:var(--sv-text); letter-spacing:.5px; display:flex; align-items:center; justify-content:space-between; }
        .sv-pay-row-val .sv-visa-text {
            font-size:20px; font-weight:900; font-style:italic; color:#1a5abb;
            letter-spacing:-1px;
        }
        .sv-pay-row-val .sv-mc-dots { display:flex; }
        .sv-mc-dot { width:26px; height:26px; border-radius:50%; }
        .sv-mc-dot:first-child { background:rgba(235,0,27,.85); }
        .sv-mc-dot:last-child  { background:rgba(255,160,0,.85); margin-left:-10px; }
        .sv-pay-valid-box {
            margin-top:18px; padding:14px 16px; border-radius:10px;
            background:rgba(34,197,94,.08); border:1.5px solid rgba(34,197,94,.25);
            display:flex; align-items:center; gap:14px;
        }
        .sv-pay-valid-icon {
            width:40px; height:40px; border-radius:50%; flex-shrink:0;
            background:rgba(34,197,94,.15); border:2px solid rgba(34,197,94,.4);
            display:flex; align-items:center; justify-content:center;
            color:#22c55e; font-size:18px;
        }
        .sv-pay-valid-text strong { font-size:14px; font-weight:700; color:#22c55e; display:block; }
        .sv-pay-valid-text span { font-size:12px; color:var(--sv-muted); }

        /* ── SECURITY ICONS BAR ── */
        .sv-security-bar {
            display:flex; gap:20px; justify-content:center; margin:20px 0 4px;
            flex-wrap:wrap;
        }
        .sv-sec-item {
            display:flex; flex-direction:column; align-items:center; gap:6px;
            font-size:11px; font-weight:600; letter-spacing:.5px; color:var(--sv-muted);
            text-transform:uppercase;
        }
        .sv-sec-icon {
            width:44px; height:44px; border-radius:50%;
            border:1.5px solid var(--sv-border); background:var(--sv-bg-alt);
            display:flex; align-items:center; justify-content:center;
            font-size:16px; color:var(--sv-primary); transition:all .25s;
        }
        .sv-sec-icon:hover { border-color:#3a7bd5; color:#3a7bd5; transform:scale(1.08); }
        body.dark-mode .sv-sec-icon { background:#111; border-color:#222; }
        .sv-secure-footer {
            display:flex; align-items:center; justify-content:center; gap:8px;
            padding:12px 20px; background:var(--sv-bg-alt); border-radius:8px;
            font-size:12.5px; color:var(--sv-muted); margin-top:16px;
        }
        body.dark-mode .sv-secure-footer { background:#0d0f14; }

        /* ── CARD INPUT FORM ── */
        .sv-card-form { padding:4px 0; }
        .sv-card-form-group { margin-bottom:18px; }
        .sv-card-label {
            font-size:10.5px; font-weight:700; letter-spacing:1.5px;
            text-transform:uppercase; color:var(--sv-muted); display:block; margin-bottom:7px;
        }
        .sv-card-input {
            width:100%; padding:13px 16px; border-radius:8px;
            border:1.5px solid var(--sv-border); background:var(--sv-input-bg);
            color:var(--sv-text); font-size:15px; font-family:'Jost',sans-serif;
            outline:none; transition:all .25s;
        }
        .sv-card-input:focus {
            border-color:#3a7bd5;
            box-shadow:0 0 0 4px rgba(58,123,213,.1);
        }
        .sv-card-input.sv-input-valid {
            border-color:#22c55e;
            box-shadow:0 0 0 3px rgba(34,197,94,.08);
        }
        .sv-card-input.sv-input-error {
            border-color:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,.08);
        }
        body.dark-mode .sv-card-input { background:#0e1117; border-color:#1e2535; }
        .sv-card-input-wrap { position:relative; }
        .sv-card-input-icon { position:absolute; right:14px; top:50%; transform:translateY(-50%); color:var(--sv-muted); font-size:16px; pointer-events:none; }
        .sv-card-input-badge { position:absolute; right:14px; top:50%; transform:translateY(-50%); }
        /* Number input mask */
        .sv-card-input[name="card_number"] { letter-spacing:3px; font-family:'Courier New',monospace; font-size:16px; }
        .sv-card-input[name="cvv"] { letter-spacing:4px; font-family:'Courier New',monospace; }

        /* ── COD section ── */
        .sv-cod-box {
            border:1.5px dashed var(--sv-border); border-radius:12px;
            padding:32px 24px; text-align:center; color:var(--sv-muted);
            background:var(--sv-bg-alt);
        }
        .sv-cod-icon { font-size:3rem; margin-bottom:12px; opacity:.6; }
        body.dark-mode .sv-cod-box { background:#0d0f14; }

        /* ── PROCESSING OVERLAY ── */
        .sv-processing {
            position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(6px);
            z-index:9999; display:none; align-items:center; justify-content:center;
        }
        .sv-processing.active { display:flex; }
        .sv-processing-box {
            background:#0e1117; border-radius:20px; padding:40px 48px;
            text-align:center; border:1px solid rgba(255,255,255,.08);
            box-shadow:0 40px 100px rgba(0,0,0,.7); min-width:320px;
        }
        .sv-processing-spinner {
            width:60px; height:60px; border-radius:50%; margin:0 auto 20px;
            border:3px solid rgba(255,255,255,.08);
            border-top-color:#3a7bd5;
            animation:svSpin .8s linear infinite;
        }
        @keyframes svSpin { to{ transform:rotate(360deg); } }
        .sv-processing-title { font-size:16px; font-weight:700; color:#fff; margin-bottom:6px; }
        .sv-processing-sub { font-size:13px; color:#666; }
        .sv-processing-steps { margin-top:20px; text-align:left; }
        .sv-proc-step { display:flex; align-items:center; gap:10px; padding:6px 0; font-size:13px; color:#555; transition:color .3s; }
        .sv-proc-step.done { color:#22c55e; }
        .sv-proc-step.active { color:#3a7bd5; }
        .sv-proc-step i { width:18px; text-align:center; }
        /* Success state */
        .sv-processing-success { display:none; }
        .sv-success-ring {
            width:70px; height:70px; border-radius:50%; margin:0 auto 16px;
            background:rgba(34,197,94,.12); border:3px solid #22c55e;
            display:flex; align-items:center; justify-content:center;
            font-size:28px; color:#22c55e; animation:svPop .4s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes svPop { from{transform:scale(.3);opacity:0} to{transform:scale(1);opacity:1} }

        /* ── PLACE ORDER BUTTON ── */
        .sv-place-order-btn {
            width:100%; padding:16px; border-radius:10px; border:none; cursor:pointer;
            font-size:14px; font-weight:700; letter-spacing:2px; text-transform:uppercase;
            background:linear-gradient(135deg,#1a5abb,#3a7bd5,#1a8ab5);
            background-size:200% auto; color:#fff;
            transition:all .3s; position:relative; overflow:hidden;
            box-shadow:0 8px 24px rgba(26,90,187,.35);
        }
        .sv-place-order-btn:hover {
            background-position:right center;
            transform:translateY(-1px);
            box-shadow:0 12px 32px rgba(26,90,187,.45);
        }
        .sv-place-order-btn:active { transform:translateY(0); }
        .sv-place-order-btn.cod-btn {
            background:linear-gradient(135deg,#2d2d2d,#111);
            box-shadow:0 8px 24px rgba(0,0,0,.35);
        }
    </style>
@endpush
@section('content')
    @php
        $locale = app()->getLocale();
        $fee    = floatval(\App\Models\Setting::get('general.shipping_fee','30.00'));
        $free   = floatval(\App\Models\Setting::get('general.free_shipping_above','500.00'));
        if($cart->total() >= $free) $fee = 0;
        $total  = $cart->total() + $fee;
    @endphp

    <div class="sv-breadcrumb">
        <div class="container">
            <a href="{{ route('home') }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a><span>/</span>
            <strong>{{ $locale==='ar'?'الدفع':'Checkout' }}</strong>
        </div>
    </div>

    <div class="container py-5">
        <form action="{{ route('checkout.store') }}" method="POST" id="svCheckoutForm">
            @csrf
            <input type="hidden" name="payment" id="svPaymentMethod" value="cod">
            <input type="hidden" name="card_token" id="svCardToken" value="">

            <div class="row g-5">

                {{-- LEFT: Shipping + Payment --}}
                <div class="col-lg-7">

                    {{-- Shipping Details --}}
                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:var(--sv-muted);margin-bottom:16px">
                        {{ $locale==='ar'?'01 — بيانات الشحن':'01 — Shipping Details' }}
                    </div>
                    <div class="row g-3 mb-5">
                        <div class="col-sm-6">
                            <label class="sv-card-label">{{ $locale==='ar'?'الاسم الكامل':'Full Name' }}</label>
                            <input name="name" class="sv-card-input" value="{{ auth()->user()?->name }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="sv-card-label">{{ $locale==='ar'?'البريد الإلكتروني':'Email Address' }}</label>
                            <input name="email" type="email" class="sv-card-input" value="{{ auth()->user()?->email }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="sv-card-label">{{ $locale==='ar'?'الهاتف':'Phone Number' }}</label>
                            <input name="phone" class="sv-card-input" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="sv-card-label">{{ $locale==='ar'?'المدينة':'City' }}</label>
                            <input name="city" class="sv-card-input" value="Dubai" required>
                        </div>
                        <div class="col-12">
                            <label class="sv-card-label">{{ $locale==='ar'?'العنوان الكامل':'Full Address' }}</label>
                            <input name="address" class="sv-card-input" required>
                        </div>
                        <div class="col-12">
                            <label class="sv-card-label">{{ $locale==='ar'?'ملاحظات (اختياري)':'Order Notes (optional)' }}</label>
                            <textarea name="notes" class="sv-card-input" rows="2" style="resize:none"></textarea>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div style="font-size:11px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:var(--sv-muted);margin-bottom:16px">
                        {{ $locale==='ar'?'02 — طريقة الدفع':'02 — Payment Method' }}
                    </div>

                    <div class="sv-pay-methods">
                        <button type="button" class="sv-pay-btn" id="btnCOD" onclick="svSelectPayment('cod')">
                            <i class="bi bi-truck"></i>
                            {{ $locale==='ar'?'الدفع عند الاستلام':'Cash on Delivery' }}
                        </button>
                        <button type="button" class="sv-pay-btn" id="btnCard" onclick="svSelectPayment('card')">
                            <i class="bi bi-credit-card-2-front"></i>
                            {{ $locale==='ar'?'بطاقة بنكية':'Credit / Debit Card' }}
                        </button>
                        <button type="button" class="sv-pay-btn" id="btnApple" onclick="svSelectPayment('apple')">
                            <i class="bi bi-apple"></i>
                            {{ $locale==='ar'?'أبل باي':'Apple Pay' }}
                        </button>
                    </div>

                    {{-- COD Section --}}
                    <div id="svSectionCOD" class="sv-cod-box mb-4">
                        <div class="sv-cod-icon">🚚</div>
                        <h5 style="font-size:16px;font-weight:700;color:var(--sv-text);margin-bottom:8px">{{ $locale==='ar'?'الدفع عند الاستلام':'Cash on Delivery' }}</h5>
                        <p style="font-size:13.5px;margin:0">{{ $locale==='ar'?'سيتم تحصيل المبلغ عند استلام الطلب. مجاني وآمن.':'Pay when your order arrives. Free and safe.' }}</p>
                    </div>

                    {{-- Apple Pay placeholder --}}
                    <div id="svSectionApple" style="display:none" class="sv-cod-box mb-4">
                        <div class="sv-cod-icon" style="opacity:.8">🍎</div>
                        <h5 style="font-size:16px;font-weight:700;color:var(--sv-text);margin-bottom:8px">Apple Pay</h5>
                        <p style="font-size:13.5px;margin:0">{{ $locale==='ar'?'ادفع بسرعة وأمان باستخدام Apple Pay.':'Pay quickly and securely using Apple Pay.' }}</p>
                        <div style="margin-top:16px">
                            <button type="button" style="background:#000;color:#fff;border:none;padding:12px 40px;border-radius:10px;font-size:16px;cursor:pointer;letter-spacing:.5px">
                                <i class="bi bi-apple"></i>  Pay
                            </button>
                        </div>
                    </div>

                    {{-- CARD SECTION --}}
                    <div id="svSectionCard" style="display:none">

                        {{-- 3D Card Visualizer --}}
                        <div class="sv-card-scene" id="svCardScene">
                            <div class="sv-card-3d" id="svCard3D">
                                {{-- Front --}}
                                <div class="sv-card-face sv-card-front">
                                    <div class="sv-card-chip"></div>
                                    <svg class="sv-card-nfc" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="1.5">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9 16.5v-9l7 4.5-7 4.5z"/>
                                    </svg>
                                    {{-- Card logo placeholder --}}
                                    <div class="sv-card-logo" id="svCardLogoFront">
                                        <span style="font-size:22px;font-style:italic;font-weight:900;color:#fff;text-shadow:0 2px 8px rgba(0,0,0,.4)">VISA</span>
                                    </div>
                                    <div class="sv-card-number" id="svCardNumDisplay">•••• •••• •••• ••••</div>
                                    <div class="sv-card-name" id="svCardNameDisplay">YOUR NAME</div>
                                    <div class="sv-card-expiry">
                                        <div class="sv-cf-label">VALID THRU</div>
                                        <div class="sv-cf-val" id="svCardExpDisplay">MM/YY</div>
                                    </div>
                                    <div class="sv-card-holo"></div>
                                </div>
                                {{-- Back --}}
                                <div class="sv-card-face sv-card-back">
                                    <div style="position:absolute;top:100px;right:0;left:0;padding:0 28px">
                                        <div class="sv-card-cvv-bar" id="svCardCVVDisplay">•••</div>
                                    </div>
                                    <div style="position:absolute;bottom:28px;right:28px">
                                        <div class="sv-card-logo" style="position:static">
                                            <span style="font-size:20px;font-style:italic;font-weight:900;color:#fff;opacity:.7">VISA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Form --}}
                        <div class="sv-card-form">
                            <div class="sv-card-form-group">
                                <label class="sv-card-label">{{ $locale==='ar'?'اسم صاحب البطاقة':'Name on Card' }}</label>
                                <div class="sv-card-input-wrap">
                                    <input type="text" id="svCardName" class="sv-card-input" placeholder="JAMIE JONES" autocomplete="cc-name"
                                           oninput="svCardUpdate()" style="text-transform:uppercase;letter-spacing:2px">
                                    <span class="sv-card-input-icon"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="sv-card-form-group">
                                <label class="sv-card-label">{{ $locale==='ar'?'رقم البطاقة':'Card Number' }}</label>
                                <div class="sv-card-input-wrap">
                                    <input type="tel" id="svCardNum" name="card_number_display" class="sv-card-input" placeholder="0000 0000 0000 0000"
                                           maxlength="19" autocomplete="cc-number" oninput="svFormatCardNum(this)" style="letter-spacing:3px;font-family:'Courier New',monospace">
                                    <span class="sv-card-input-badge" id="svCardBadge">
              <span style="font-size:17px;font-weight:900;font-style:italic;color:#1a5abb">VISA</span>
            </span>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="sv-card-label">{{ $locale==='ar'?'تاريخ الانتهاء':'Valid Through' }}</label>
                                    <input type="tel" id="svCardExp" name="card_exp" class="sv-card-input" placeholder="MM / YY"
                                           maxlength="7" autocomplete="cc-exp" oninput="svFormatExp(this)">
                                </div>
                                <div class="col-6">
                                    <label class="sv-card-label">{{ $locale==='ar'?'رمز الأمان':'CVV / CVC' }}</label>
                                    <input type="tel" id="svCardCVV" name="card_cvv" class="sv-card-input" placeholder="•••"
                                           maxlength="4" autocomplete="cc-csc"
                                           onfocus="document.getElementById('svCard3D').classList.add('is-flipped')"
                                           onblur="document.getElementById('svCard3D').classList.remove('is-flipped')"
                                           oninput="svUpdateCVV(this.value)">
                                </div>
                            </div>
                        </div>

                        {{-- Payment Details Summary Panel --}}
                        <div class="sv-pay-panel mt-4" id="svPayPanel" style="display:none">
                            <div class="sv-pay-panel-header">
                                <div class="sv-pay-panel-title">{{ $locale==='ar'?'تفاصيل الدفع':'Payment Details' }}</div>
                                <div class="sv-secure-badge"><i class="bi bi-shield-check"></i></div>
                            </div>
                            <div class="sv-pay-panel-body">
                                <div class="sv-pay-row">
                                    <div class="sv-pay-row-label">{{ $locale==='ar'?'اسم صاحب البطاقة':'Name on Card' }}</div>
                                    <div class="sv-pay-row-val" id="pdName">—</div>
                                </div>
                                <div class="sv-pay-row">
                                    <div class="sv-pay-row-label">{{ $locale==='ar'?'رقم البطاقة':'Card Number' }}</div>
                                    <div class="sv-pay-row-val">
                                        <span id="pdNumber">—</span>
                                        <span class="sv-visa-text" id="pdBrand">VISA</span>
                                    </div>
                                </div>
                                <div class="sv-pay-row">
                                    <div class="row g-0">
                                        <div class="col-6">
                                            <div class="sv-pay-row-label">{{ $locale==='ar'?'صالح حتى':'Valid Through' }}</div>
                                            <div class="sv-pay-row-val" id="pdExp">—</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="sv-pay-row-label">CVV</div>
                                            <div class="sv-pay-row-val" id="pdCVV">—</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sv-pay-valid-box" id="svPayValid" style="display:none">
                                    <div class="sv-pay-valid-icon"><i class="bi bi-check-circle-fill"></i></div>
                                    <div class="sv-pay-valid-text">
                                        <strong>{{ $locale==='ar'?'معلومات الدفع صحيحة':'Payment information is valid' }}</strong>
                                        <span>{{ $locale==='ar'?'يمكنك المتابعة بأمان.':'You can safely proceed with your transaction.' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Security icons --}}
                        <div class="sv-security-bar mt-4">
                            @foreach([['bi-lock-fill','Secure Payment'],['bi-shield-lock-fill','256-bit Encryption'],['bi-patch-check-fill','Verified Card'],['bi-credit-card-fill','Visa Trusted']] as [$icon,$label])
                                <div class="sv-sec-item">
                                    <div class="sv-sec-icon"><i class="bi {{ $icon }}"></i></div>
                                    <span>{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="sv-secure-footer">
                            <i class="bi bi-shield-fill-check" style="color:#22c55e"></i>
                            {{ $locale==='ar'?'معلومات الدفع الخاصة بك آمنة ومشفرة':'Your payment information is secure and encrypted' }}
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Order Summary --}}
                <div class="col-lg-5">
                    <div style="position:sticky;top:80px">
                        <div class="sv-card mb-3">
                            <div class="sv-card-title">{{ $locale==='ar'?'ملخص الطلب':'Order Summary' }}</div>

                            @foreach($cart->items as $item)
                                @php
                                    $img = null;
                                    if ($item->variant) {
                                      $pm = $item->variant->media?->where('is_primary',1)->first() ?: $item->variant->media?->first();
                                      if ($pm) $img = $pm->url;
                                    }
                                    if (!$img && $item->product->cover_image && str_starts_with($item->product->cover_image,'http')) $img = $item->product->cover_image;
                                @endphp
                                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--sv-border)">
                                    <div style="width:52px;height:68px;border-radius:5px;overflow:hidden;flex-shrink:0;background:var(--sv-bg-alt)">
                                        @if($img)<img src="{{ $img }}" style="width:100%;height:100%;object-fit:cover" onerror="this.parentNode.innerHTML='<div style=\'width:100%;height:100%;background:var(--sv-bg-alt)\'></div>'">@endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div style="font-size:13px;font-weight:600">{{ $item->product->nameLocale() }}</div>
                                        @if($item->variant)<div style="font-size:11px;color:var(--sv-muted)">{{ $item->variant->nameLocale() }}</div>@endif
                                        <div style="font-size:12px;color:var(--sv-muted);margin-top:2px">× {{ $item->quantity }}</div>
                                    </div>
                                    <div style="font-size:13px;font-weight:600;white-space:nowrap">{{ number_format($item->price*$item->quantity,2) }} AED</div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mb-2" style="font-size:13px"><span>{{ $locale==='ar'?'المجموع الفرعي':'Subtotal' }}</span><span>{{ number_format($cart->total(),2) }} AED</span></div>
                            <div class="d-flex justify-content-between mb-2" style="font-size:13px">
                                <span>{{ $locale==='ar'?'الشحن':'Shipping' }}</span>
                                <span>{{ $fee > 0 ? number_format($fee,2).' AED' : ($locale==='ar'?'مجاني':'Free') }}</span>
                            </div>
                            <div id="svDiscountRow" style="display:none;font-size:13px" class="d-flex justify-content-between mb-2 text-success">
                                <span>{{ $locale==='ar'?'خصم':'Discount' }}</span><span class="sv-disc-val"></span>
                            </div>
                            <hr style="border-color:var(--sv-border)">
                            <div class="d-flex justify-content-between fw-bold" style="font-size:16px">
                                <span>{{ $locale==='ar'?'الإجمالي':'Total' }}</span>
                                <span id="svFinalTotal">{{ number_format($total,2) }} AED</span>
                            </div>

                            {{-- Coupon --}}
                            <div class="d-flex gap-2 mt-3">
                                <input id="svCouponCode" class="sv-card-input" placeholder="{{ $locale==='ar'?'كود الخصم':'Coupon code' }}" style="flex:1;padding:10px 13px;font-size:13px">
                                <button type="button" id="svApplyCoupon" class="btn btn-outline-dark text-uppercase" style="font-size:11px;letter-spacing:1px;white-space:nowrap">
                                    {{ $locale==='ar'?'تطبيق':'Apply' }}
                                </button>
                            </div>
                            <div id="svCouponMsg" style="font-size:12px;margin-top:6px"></div>
                        </div>

                        {{-- Place Order Button --}}
                        <button type="submit" class="sv-place-order-btn cod-btn" id="svPlaceOrderBtn">
                            <span id="svBtnText">🚚 {{ $locale==='ar'?'تأكيد الطلب':'Place Order — Cash on Delivery' }}</span>
                        </button>

                        <div style="text-align:center;margin-top:14px;font-size:12px;color:var(--sv-muted)">
                            <i class="bi bi-lock-fill" style="color:#22c55e"></i>
                            {{ $locale==='ar'?'بيئة دفع آمنة ومشفرة بالكامل':'Fully encrypted & secure checkout' }}
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- Processing Overlay --}}
    <div class="sv-processing" id="svProcessing">
        <div class="sv-processing-box">
            <div id="svProcSpinner">
                <div class="sv-processing-spinner"></div>
                <div class="sv-processing-title">{{ $locale==='ar'?'جاري معالجة الدفع...':'Processing Payment...' }}</div>
                <div class="sv-processing-sub">{{ $locale==='ar'?'الرجاء الانتظار':'Please wait a moment' }}</div>
                <div class="sv-processing-steps mt-3">
                    <div class="sv-proc-step" id="step1"><i class="bi bi-circle"></i> {{ $locale==='ar'?'التحقق من البطاقة':'Verifying card details' }}</div>
                    <div class="sv-proc-step" id="step2"><i class="bi bi-circle"></i> {{ $locale==='ar'?'الاتصال بالمصرف':'Connecting to bank' }}</div>
                    <div class="sv-proc-step" id="step3"><i class="bi bi-circle"></i> {{ $locale==='ar'?'تأمين المعاملة':'Securing transaction' }}</div>
                    <div class="sv-proc-step" id="step4"><i class="bi bi-circle"></i> {{ $locale==='ar'?'تأكيد الدفع':'Confirming payment' }}</div>
                </div>
            </div>
            <div id="svProcSuccess" style="display:none">
                <div class="sv-success-ring">✓</div>
                <div class="sv-processing-title" style="color:#22c55e">{{ $locale==='ar'?'تم الدفع بنجاح!':'Payment Successful!' }}</div>
                <div class="sv-processing-sub">{{ $locale==='ar'?'جاري تأكيد طلبك...':'Confirming your order...' }}</div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        /* ═══════════════════════════════════════════════
           STYLEVERA PAYMENT — Complete Interactive Logic
        ═══════════════════════════════════════════════ */

        // Payment method selection
        function svSelectPayment(method) {
            // Update hidden input
            document.getElementById('svPaymentMethod').value = method;

            // Update button states
            document.querySelectorAll('.sv-pay-btn').forEach(b => b.classList.remove('active'));
            const btnMap = { cod:'btnCOD', card:'btnCard', apple:'btnApple' };
            document.getElementById(btnMap[method])?.classList.add('active');

            // Show/hide sections
            document.getElementById('svSectionCOD').style.display    = method === 'cod'   ? '' : 'none';
            document.getElementById('svSectionCard').style.display   = method === 'card'  ? '' : 'none';
            document.getElementById('svSectionApple').style.display  = method === 'apple' ? '' : 'none';

            // Update button style
            const btn  = document.getElementById('svPlaceOrderBtn');
            const text = document.getElementById('svBtnText');
            if (method === 'card') {
                btn.classList.remove('cod-btn');
                text.innerHTML = '🔒 {{ $locale==='ar'?'ادفع الآن':'Pay Now' }} — {{ number_format($total,2) }} AED';
            } else if (method === 'apple') {
                btn.classList.remove('cod-btn');
                btn.style.background = 'linear-gradient(135deg,#1a1a1a,#333)';
                text.innerHTML = ' Pay — {{ number_format($total,2) }} AED';
            } else {
                btn.classList.add('cod-btn');
                btn.style.background = '';
                text.innerHTML = '🚚 {{ $locale==='ar'?'تأكيد الطلب':'Place Order' }} — {{ $locale==='ar'?'الدفع عند الاستلام':'Cash on Delivery' }}';
            }
        }

        // Init — select COD by default
        svSelectPayment('cod');

        /* ── CARD NUMBER FORMAT ── */
        function svFormatCardNum(el) {
            let v = el.value.replace(/\D/g,'').substring(0,16);
            el.value = v.replace(/(.{4})/g,'$1 ').trim();
            svCardUpdate();
            // Detect card type
            const brand = v.startsWith('4') ? 'VISA' :
                (v.startsWith('5') || v.startsWith('2')) ? 'MC' :
                    v.startsWith('3') ? 'AMEX' : 'VISA';
            svUpdateBrand(brand);
        }

        /* ── EXPIRY FORMAT ── */
        function svFormatExp(el) {
            let v = el.value.replace(/\D/g,'');
            if (v.length >= 2) v = v.substring(0,2) + ' / ' + v.substring(2,4);
            el.value = v;
            svCardUpdate();
        }

        /* ── LIVE CARD 3D UPDATE ── */
        function svCardUpdate() {
            const name = (document.getElementById('svCardName').value || 'YOUR NAME').toUpperCase();
            const num  = document.getElementById('svCardNum').value || '•••• •••• •••• ••••';
            const exp  = document.getElementById('svCardExp').value || 'MM/YY';
            // Display
            document.getElementById('svCardNumDisplay').textContent  = num || '•••• •••• •••• ••••';
            document.getElementById('svCardNameDisplay').textContent = name;
            document.getElementById('svCardExpDisplay').textContent  = exp.replace(' / ','/') || 'MM/YY';
            // Update payment details panel
            svUpdatePanel();
        }

        function svUpdateCVV(val) {
            document.getElementById('svCardCVVDisplay').textContent = val ? val.replace(/./g,'•') : '•••';
            svUpdatePanel();
        }

        let _cardBrand = 'VISA';
        function svUpdateBrand(brand) {
            _cardBrand = brand;
            const logo = document.getElementById('svCardLogoFront');
            const badge = document.getElementById('svCardBadge');
            if (brand === 'MC') {
                logo.innerHTML  = '<div style="display:flex;"><div style="width:30px;height:30px;border-radius:50%;background:rgba(235,0,27,.9)"></div><div style="width:30px;height:30px;border-radius:50%;background:rgba(255,160,0,.9);margin-left:-12px"></div></div>';
                badge.innerHTML = '<div style="display:flex;align-items:center;gap:-6px"><div style="width:22px;height:22px;border-radius:50%;background:rgba(235,0,27,.85)"></div><div style="width:22px;height:22px;border-radius:50%;background:rgba(255,160,0,.85);margin-left:-8px"></div></div>';
            } else if (brand === 'AMEX') {
                logo.innerHTML  = '<span style="font-size:13px;font-weight:800;color:#fff;letter-spacing:1px;background:rgba(255,255,255,.15);padding:4px 8px;border-radius:4px">AMEX</span>';
                badge.innerHTML = '<span style="font-size:13px;font-weight:800;color:#2e77bc">AMEX</span>';
            } else {
                logo.innerHTML  = '<span style="font-size:22px;font-style:italic;font-weight:900;color:#fff;text-shadow:0 2px 8px rgba(0,0,0,.4)">VISA</span>';
                badge.innerHTML = '<span style="font-size:17px;font-weight:900;font-style:italic;color:#1a5abb">VISA</span>';
            }
            document.getElementById('pdBrand').textContent = brand;
        }

        /* ── PAYMENT DETAILS PANEL UPDATE ── */
        function svUpdatePanel() {
            const name = document.getElementById('svCardName').value;
            const num  = document.getElementById('svCardNum').value;
            const exp  = document.getElementById('svCardExp').value;
            const cvv  = document.getElementById('svCardCVV').value;

            const filled = name.length > 1 && num.replace(/\s/g,'').length >= 12 && exp.length >= 4;

            if (filled) {
                document.getElementById('svPayPanel').style.display = '';
                document.getElementById('pdName').textContent   = name.toUpperCase();
                document.getElementById('pdNumber').textContent = num || '—';
                document.getElementById('pdExp').textContent    = exp.replace(' / ','/') || '—';
                document.getElementById('pdCVV').textContent    = cvv ? '•'.repeat(cvv.length) : '—';

                // Valid box — show when all 4 fields filled
                const allFilled = name.length > 1 && num.replace(/\s/g,'').length >= 15 && exp.length >= 4 && cvv.length >= 3;
                document.getElementById('svPayValid').style.display = allFilled ? '' : 'none';

                // Validate input styling
                svValidateInput(document.getElementById('svCardName'), name.length > 1);
                svValidateInput(document.getElementById('svCardNum'), num.replace(/\s/g,'').length >= 15);
                svValidateInput(document.getElementById('svCardExp'), exp.length >= 4);
                svValidateInput(document.getElementById('svCardCVV'), cvv.length >= 3);
            } else {
                document.getElementById('svPayPanel').style.display = 'none';
            }
        }

        function svValidateInput(el, valid) {
            el.classList.toggle('sv-input-valid', valid);
            el.classList.toggle('sv-input-error', !valid && el.value.length > 0);
        }

        /* ── FORM SUBMIT — Card Payment Processing Animation ── */
        document.getElementById('svCheckoutForm').addEventListener('submit', function(e) {
            const method = document.getElementById('svPaymentMethod').value;

            if (method === 'card') {
                e.preventDefault();
                // Validate card fields
                const name = document.getElementById('svCardName').value.trim();
                const num  = document.getElementById('svCardNum').value.replace(/\s/g,'');
                const exp  = document.getElementById('svCardExp').value.trim();
                const cvv  = document.getElementById('svCardCVV').value.trim();

                if (!name || num.length < 15 || exp.length < 4 || cvv.length < 3) {
                    svToast('{{ $locale==='ar'?'يرجى إكمال بيانات البطاقة':'Please complete all card details' }}', 'error');
                    // Shake the form
                    document.querySelector('.sv-card-form').style.animation = 'none';
                    setTimeout(() => document.querySelector('.sv-card-form').style.animation = '', 100);
                    return;
                }

                // Show processing overlay
                document.getElementById('svProcessing').classList.add('active');
                document.body.style.overflow = 'hidden';

                // Animate steps
                const steps = ['step1','step2','step3','step4'];
                const delays = [600, 1400, 2200, 3000];
                steps.forEach((id, i) => {
                    setTimeout(() => {
                        // Mark previous as done
                        if (i > 0) {
                            const prev = document.getElementById(steps[i-1]);
                            prev.classList.remove('active');
                            prev.classList.add('done');
                            prev.querySelector('i').className = 'bi bi-check-circle-fill';
                        }
                        // Mark current as active
                        const cur = document.getElementById(id);
                        cur.classList.add('active');
                        cur.querySelector('i').className = 'bi bi-circle-fill';
                    }, delays[i]);
                });

                // Complete — show success, then submit
                setTimeout(() => {
                    document.getElementById(steps[steps.length-1]).classList.remove('active');
                    document.getElementById(steps[steps.length-1]).classList.add('done');
                    document.getElementById(steps[steps.length-1]).querySelector('i').className = 'bi bi-check-circle-fill';
                    // Show success
                    document.getElementById('svProcSpinner').style.display = 'none';
                    document.getElementById('svProcSuccess').style.display = 'block';
                    // Store card token (simulated)
                    document.getElementById('svCardToken').value = 'sim_' + Date.now();
                    // Submit form after success animation
                    setTimeout(() => { document.getElementById('svCheckoutForm').submit(); }, 1400);
                }, 3800);
            }
            // COD and Apple Pay submit immediately
        });

        // Init focus effects
        document.getElementById('svCardName')?.addEventListener('focus', () => {
            document.getElementById('svCard3D')?.classList.remove('is-flipped');
        });
    </script>
@endpush
