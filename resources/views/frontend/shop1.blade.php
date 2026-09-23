@extends('layouts.app')
@section('title',app()->getLocale()==='ar'?'المتجر — ستايل فيرا':'Shop — Stylevera')
@section('content')
    @php $locale=app()->getLocale(); @endphp
    <div class="sv-breadcrumb">
        <div class="container"><a href="{{ route('home') }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a><span>/</span><strong>{{ $locale==='ar'?'المتجر':'Shop' }}</strong></div>
    </div>
    <div class="container py-5">
        <div class="row">
            {{-- Filter Sidebar --}}
            <div class="col-lg-3 mb-5">
                <form method="GET" action="{{ route('shop') }}" id="shopForm">
                    <div class="sv-card mb-3">
                        <div class="sv-filter-title">{{ $locale==='ar'?'الفئات':'Categories' }}</div>
                        <div class="sv-filter-item" onclick="document.querySelector('[name=cat]').value='';document.getElementById('shopForm').submit()">
                            <span>{{ $locale==='ar'?'الكل':'All' }}</span><small style="color:#aaa">{{ $categories->sum('products_count') }}</small>
                        </div>
                        @foreach($categories as $cat)
                            <div class="sv-filter-item" onclick="document.querySelector('[name=cat]').value='{{ $cat->slug }}';document.getElementById('shopForm').submit()" style="{{ request('cat')===$cat->slug?'color:var(--sv-primary);font-weight:600':'' }}">
                                <span>{{ $cat->nameLocale() }}</span><small style="color:#aaa">({{ $cat->products_count }})</small>
                            </div>
                        @endforeach
                        <input type="hidden" name="cat" value="{{ request('cat') }}">
                    </div>

                    <div class="sv-card mb-3">
                        <div class="sv-filter-title">{{ $locale==='ar'?'الجنس':'Gender' }}</div>
                        @php
                            $genderOptions = [
                              ['val' => '',       'en' => 'All',     'ar' => 'الكل'],
                              ['val' => 'women',  'en' => 'Women',   'ar' => 'نساء'],
                              ['val' => 'men',    'en' => 'Men',     'ar' => 'رجال'],
                              ['val' => 'unisex', 'en' => 'Unisex',  'ar' => 'للجنسين'],
                            ];
                        @endphp
                        @foreach($genderOptions as $option)
                            <label class="sv-filter-item" style="cursor:pointer">
                                <span>{{ $locale==='ar' ? $option['ar'] : $option['en'] }}</span>
                                <input type="radio" name="gender" value="{{ $option['val'] }}" {{ request('gender')===$option['val']?'checked':'' }} onchange="this.form.submit()" style="accent-color:var(--sv-primary)">
                            </label>
                        @endforeach
                    </div>

                    <div class="sv-card mb-3">
                        <div class="sv-filter-title">{{ $locale==='ar'?'الترتيب':'Sort By' }}</div>
                        <select name="sort" class="sv-select" onchange="this.form.submit()">
                            <option value="">{{ $locale==='ar'?'الافتراضي':'Default' }}</option>
                            <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>{{ $locale==='ar'?'الأحدث':'Newest' }}</option>
                            <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>{{ $locale==='ar'?'السعر: الأقل':'Price: Low to High' }}</option>
                            <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>{{ $locale==='ar'?'السعر: الأعلى':'Price: High to Low' }}</option>
                        </select>
                    </div>

                    @if(request()->hasAny(['cat','gender','sort','search']))
                        <a href="{{ route('shop') }}" class="btn btn-outline-dark w-100 text-uppercase" style="font-size:12px;letter-spacing:1px">{{ $locale==='ar'?'مسح الفلاتر':'Clear Filters' }}</a>
                    @endif
                </form>
            </div>

            {{-- Products Grid --}}
            <div class="col-lg-9">
                @if(request('search'))
                    <p style="font-size:13px;color:#999;margin-bottom:16px">{{ $products->total() }} {{ $locale==='ar'?'نتيجة لـ':'results for' }} "{{ request('search') }}"</p>
                @endif

                <div class="row g-4">
                    @forelse($products as $p)
                        @php
                            $dp = $p->getDisplayPrice();
                            $allMedia = $p->getAllMedia();
                            $primary = $allMedia->where('type','image')->where('is_primary',1)->first()
                                       ?: $allMedia->where('type','image')->first()
                                       ?: $allMedia->first();
                            $imgUrls = $allMedia->where('type','image')->pluck('url')->take(5)->values();
                        @endphp
                        <div class="col-md-4 col-6">
                            <div class="product-item image-zoom-effect link-effect">
                                <div class="image-holder position-relative">
                                    @if($primary && $primary->type==='video')
                                        <a href="{{ route('product.show',$p->slug) }}">
                                            <video src="{{ $primary->url }}" muted autoplay loop class="product-image" style="width:100%;aspect-ratio:3/4;object-fit:cover"></video>
                                        </a>
                                    @elseif($primary)
                                        <a href="{{ route('product.show',$p->slug) }}"
                                           @if($imgUrls->count()>1) class="sv-multi-img" data-original-src="{{ $primary->url }}" data-images="{{ $imgUrls->join('||') }}" @endif>
                                            <img src="{{ $primary->url }}" alt="{{ $p->nameLocale() }}" class="product-image sv-main-img img-fluid"
                                                 style="aspect-ratio:3/4;object-fit:cover" onerror="this.src='{{ asset('images/placeholder.svg') }}'">
                                        </a>
                                        @if($imgUrls->count()>1)
                                            <div class="sv-img-dots">
                                                @for($d=0;$d<min($imgUrls->count(),5);$d++)
                                                    <div class="sv-img-dot {{ $d===0?'active':'' }}"></div>
                                                @endfor
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('product.show',$p->slug) }}">
                                            <div class="product-image" style="aspect-ratio:3/4;background:linear-gradient(135deg,#f5f5f5,#ece9e4);display:flex;align-items:center;justify-content:center">
                                                <span style="font-family:'Marcellus',serif;font-size:1.5rem;color:rgba(140,144,126,0.4);letter-spacing:.05em">SV</span>
                                            </div>
                                        </a>
                                    @endif

                                    <a href="#" class="btn-icon btn-wishlist" onclick="svToggleWishlist({{ $p->id }},this);return false">
                                        <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg>
                                    </a>
                                    @if($p->is_new_arrival)<span class="sv-new-badge">{{ $locale==='ar'?'جديد':'NEW' }}</span>@endif
                                    @if($dp['sale'])<span class="price-badge" style="position:absolute;top:{{ $p->is_new_arrival?'32':'10' }}px;left:10px">SALE</span>@endif

                                    <div class="product-content">
                                        <h5 class="element-title text-uppercase fs-5 mt-3"><a href="{{ route('product.show',$p->slug) }}">{{ $p->nameLocale() }}</a></h5>
                                        <a href="{{ route('product.show',$p->slug) }}" class="text-decoration-none" data-after="{{ $locale==='ar'?'أضف للسلة':'Add to cart' }}">
                  <span class="price-aed">
                    @if($dp['sale'])
                          <span class="original">{{ number_format($dp['price'],2) }} AED</span>
                          <span class="sale">{{ number_format($dp['sale'],2) }} AED</span>
                      @else
                          {{ number_format($dp['price'],2) }} AED
                      @endif
                  </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-bag-x" style="font-size:3rem;opacity:0.2;display:block;margin-bottom:16px"></i>
                            <p style="color:#aaa">{{ $locale==='ar'?'لا توجد منتجات.':'No products found.' }}</p>
                            <a href="{{ route('shop') }}" class="btn btn-dark text-uppercase" style="font-size:12px;letter-spacing:1.5px">{{ $locale==='ar'?'عرض الكل':'View All' }}</a>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
@endsection
