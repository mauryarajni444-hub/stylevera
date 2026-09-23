@extends('layouts.admin')
@section('title','Edit: '.$product->name_en)
@section('content')
<div class="row g-4">
  {{-- Left: Product Details --}}
  <div class="col-lg-8">
    <div class="sv-card mb-4">
      <div class="sv-card-title">Product Details</div>
      <form method="POST" action="{{ route('admin.products.update',$product->id) }}">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-md-6"><label class="sv-label">Name (EN) *</label><input name="name_en" class="sv-input" value="{{ $product->name_en }}" required></div>
          <div class="col-md-6"><label class="sv-label">Name (AR) *</label><input name="name_ar" class="sv-input" value="{{ $product->name_ar }}" dir="rtl" required></div>
          <div class="col-md-4"><label class="sv-label">Category</label>
            <select name="category_id" class="sv-select">
              <option value="">-- None --</option>
              @foreach($categories as $c)<option value="{{ $c->id }}" {{ $product->category_id==$c->id?'selected':'' }}>{{ $c->name_en }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-4"><label class="sv-label">Base Price (AED)</label><input name="base_price" type="number" step="0.01" class="sv-input" value="{{ $product->base_price }}"></div>
          <div class="col-md-4"><label class="sv-label">Sale Price (AED)</label><input name="sale_price" type="number" step="0.01" class="sv-input" value="{{ $product->sale_price }}"></div>
          <div class="col-md-4"><label class="sv-label">Gender</label>
            <select name="gender" class="sv-select">
              @foreach(['women','men','unisex','kids'] as $g)<option value="{{ $g }}" {{ $product->gender==$g?'selected':'' }}>{{ ucfirst($g) }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-4"><label class="sv-label">SKU</label><input name="sku" class="sv-input" value="{{ $product->sku }}"></div>
          <div class="col-md-4"><label class="sv-label">Sort Order</label><input name="sort_order" type="number" class="sv-input" value="{{ $product->sort_order }}"></div>
          <div class="col-12"><label class="sv-label">Short Description (EN)</label><textarea name="short_desc_en" class="sv-input" rows="2">{{ $product->short_desc_en }}</textarea></div>
          <div class="col-12"><label class="sv-label">Short Description (AR)</label><textarea name="short_desc_ar" class="sv-input" rows="2" dir="rtl">{{ $product->short_desc_ar }}</textarea></div>
          <div class="col-12"><label class="sv-label">Full Description (EN)</label><textarea name="description_en" class="sv-input" rows="4">{{ $product->description_en }}</textarea></div>
          <div class="col-12 d-flex gap-4 flex-wrap">
            @foreach([['is_active','Active'],['is_featured','Featured'],['is_new_arrival','New Arrival'],['is_best_seller','Best Seller']] as [$n,$l])
            <label style="cursor:pointer;display:flex;gap:6px;align-items:center;font-size:13px">
              <input type="checkbox" name="{{ $n }}" value="1" {{ $product->$n?'checked':'' }}>{{ $l }}
            </label>
            @endforeach
          </div>
          <div class="col-12"><button class="btn btn-dark text-uppercase" style="letter-spacing:1.5px;padding:10px 28px">Save Product</button></div>
        </div>
      </form>
    </div>

    {{-- Cover Image Upload --}}
    <div class="sv-card mb-4">
      <div class="sv-card-title">Cover Image <span style="font-weight:400;color:#999;font-size:11px">(uploads to AWS S3)</span></div>
      <div class="row align-items-center g-3">
        <div class="col-auto">
          <div style="width:90px;height:120px;border:1.5px solid #eee;border-radius:5px;overflow:hidden;background:#f9f9f9;display:flex;align-items:center;justify-content:center">
            <img id="svCoverPreview" src="{{ $product->cover_image ?: '' }}" alt="Cover"
              style="width:100%;height:100%;object-fit:cover;{{ $product->cover_image?'':'display:none' }}"
              onerror="this.style.display='none'">
            @if(!$product->cover_image)<i class="bi bi-image" style="font-size:2rem;color:#ddd"></i>@endif
          </div>
        </div>
        <div class="col">
          <div class="upload-zone" onclick="document.getElementById('svCoverInput').click()">
            <i class="bi bi-cloud-arrow-up" style="font-size:1.8rem;color:#8C907E"></i>
            <div style="font-size:13px;font-weight:500;margin-top:6px">Click to upload cover image</div>
            <div style="font-size:11px;color:#aaa;margin-top:3px">JPG, PNG, WEBP · max 10MB → Uploads to S3</div>
            <input type="file" id="svCoverInput" accept="image/*" style="display:none" onchange="svUploadCover(this.files,{{ $product->id }})">
          </div>
          <div style="font-size:11px;color:#aaa;margin-top:6px;word-break:break-all" id="svCoverUrl">{{ $product->cover_image ?: 'No cover set' }}</div>
        </div>
      </div>
    </div>

    {{-- VARIANTS --}}
    <div class="sv-card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <div class="sv-card-title" style="margin:0">Variants <span style="font-weight:400;color:#aaa">{{ $product->variants->count() }}</span></div>
          <div style="font-size:12px;color:#999;margin-top:2px">Each variant has its own media uploaded to AWS S3</div>
        </div>
        <button type="button" class="btn btn-dark btn-sm text-uppercase" style="font-size:11px;letter-spacing:1px" onclick="$('#svAddVariantForm').slideToggle(200)">
          + Add Variant
        </button>
      </div>

      {{-- Add Variant Form --}}
      <div id="svAddVariantForm" style="display:none;background:#fafafa;padding:18px;border-radius:7px;margin-bottom:18px;border:1.5px dashed #e0e0e0">
        <div style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8C907E;margin-bottom:12px">New Variant</div>
        <form method="POST" action="{{ route('admin.products.variants.store',$product->id) }}">
          @csrf
          <div class="row g-2">
            <div class="col-md-4"><label class="sv-label">Name EN *</label><input name="name_en" class="sv-input" placeholder="e.g. Black / M" required></div>
            <div class="col-md-4"><label class="sv-label">Name AR *</label><input name="name_ar" class="sv-input" dir="rtl" placeholder="أسود / M" required></div>
            <div class="col-md-4"><label class="sv-label">Color Name</label><input name="color" class="sv-input" placeholder="Black, Red..."></div>
            <div class="col-md-3"><label class="sv-label">Color Hex</label><input name="color_hex" type="color" class="sv-input" value="#111111" style="height:38px;padding:3px 6px"></div>
            <div class="col-md-3"><label class="sv-label">Size</label><input name="size" class="sv-input" placeholder="XS/S/M/L/XL"></div>
            <div class="col-md-3"><label class="sv-label">Price (AED) *</label><input name="price" type="number" step="0.01" class="sv-input" required></div>
            <div class="col-md-3"><label class="sv-label">Sale Price</label><input name="sale_price" type="number" step="0.01" class="sv-input"></div>
            <div class="col-md-3"><label class="sv-label">Stock</label><input name="stock" type="number" class="sv-input" value="0"></div>
            <div class="col-md-3"><label class="sv-label">SKU</label><input name="sku" class="sv-input"></div>
            <div class="col-md-3"><label class="sv-label">Material</label><input name="material" class="sv-input"></div>
            <div class="col-md-3 d-flex align-items-end pb-1">
              <label style="cursor:pointer;display:flex;gap:6px;align-items:center;font-size:13px">
                <input type="checkbox" name="is_default" value="1"> Default
              </label>
            </div>
            <div class="col-12">
              <button class="btn btn-dark text-uppercase" style="font-size:12px;letter-spacing:1px">Add Variant & Upload Media →</button>
            </div>
          </div>
        </form>
      </div>

      {{-- Variant Cards --}}
      @forelse($product->variants as $v)
      <div class="variant-card" id="vc_{{ $v->id }}">
        <div class="variant-card-header">
          <div class="d-flex align-items-center gap-3 flex-wrap">
            @if($v->color_hex)<span style="width:18px;height:18px;border-radius:50%;background:{{ $v->color_hex }};border:2px solid #ddd;flex-shrink:0;display:inline-block"></span>@endif
            <strong style="font-size:13.5px">{{ $v->name_en }}</strong>
            <span style="font-size:12px;color:#555;direction:rtl">{{ $v->name_ar }}</span>
            <span class="sv-badge sv-b-confirmed" style="font-size:10px">{{ number_format($v->sale_price??$v->price,2) }} AED</span>
            <span class="sv-badge {{ $v->stock>0?'sv-b-active':'sv-b-inactive' }}" style="font-size:10px">Stock: {{ $v->stock }}</span>
            @if($v->is_default)<span class="sv-badge sv-b-shipped" style="font-size:10px">DEFAULT</span>@endif
            {{-- Media button - opens VMM modal --}}
            @php $mediaCount = $v->media->count(); @endphp
            <button type="button"
              class="btn btn-sm {{ $mediaCount>0?'btn-success':'btn-warning' }}"
              style="font-size:11px;padding:3px 12px;letter-spacing:0.5px"
              onclick="svOpenVMM({{ $v->id }},'{{ addslashes($v->name_en) }} ({{ $v->size ?? '' }})')">
              <i class="bi bi-images"></i>
              {{ $mediaCount>0 ? $mediaCount.' Media' : 'Add Images' }}
            </button>
          </div>
          <i class="bi bi-chevron-down vp-toggle-icon"></i>
        </div>
        <div class="variant-card-body" style="display:none">
          <div class="row g-2 mb-3">
            <div class="col-md-3"><label class="sv-label">Price (AED)</label><input class="sv-input" id="vp_price_{{ $v->id }}" value="{{ $v->price }}"></div>
            <div class="col-md-3"><label class="sv-label">Sale Price</label><input class="sv-input" id="vp_sale_{{ $v->id }}" value="{{ $v->sale_price }}"></div>
            <div class="col-md-2"><label class="sv-label">Stock</label><input type="number" class="sv-input" id="vp_stock_{{ $v->id }}" value="{{ $v->stock }}"></div>
            <div class="col-md-2"><label class="sv-label">SKU</label><input class="sv-input" id="vp_sku_{{ $v->id }}" value="{{ $v->sku }}"></div>
            <div class="col-md-2 d-flex align-items-end">
              <button class="btn btn-dark w-100 text-uppercase" style="font-size:11px;padding:9px 0" onclick="updateVariant({{ $v->id }})">Save</button>
            </div>
          </div>
          {{-- Inline media preview --}}
          @if($v->media->count())
          <div style="margin-bottom:12px">
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#aaa;margin-bottom:8px">Media ({{ $v->media->count() }} files)</div>
            <div class="sv-media-grid" id="variantMedia_{{ $v->id }}">
              @foreach($v->media as $m)
              <div class="sv-media-thumb {{ $m->is_primary?'is-primary':'' }}" id="svMc_{{ $m->id }}">
                @if($m->is_primary)<span class="sv-primary-badge">MAIN</span>@endif
                @if($m->type==='video')<video src="{{ $m->url }}" style="width:100%;height:100%;object-fit:cover;pointer-events:none"></video><span class="sv-video-badge">VIDEO</span>
                @else<img src="{{ $m->url }}" alt="" onerror="this.src='/images/placeholder.svg'">@endif
                <div class="sv-thumb-overlay"><div style="display:flex;gap:3px">
                  @if(!$m->is_primary)<button class="sv-mt-btn sv-mt-primary" onclick="svSetPrimary({{ $m->id }},{{ $v->id }})">Main</button>@endif
                  <button class="sv-mt-btn sv-mt-delete" onclick="svDeleteMedia({{ $m->id }},{{ $v->id }})">Del</button>
                </div></div>
              </div>
              @endforeach
            </div>
          </div>
          @else
          <div id="variantMedia_{{ $v->id }}" class="sv-media-grid"></div>
          @endif
          {{-- Quick upload zone --}}
          <div class="sv-upload-zone" onclick="svOpenVMM({{ $v->id }},'{{ addslashes($v->name_en) }}')">
            <i class="bi bi-cloud-arrow-up" style="font-size:1.4rem;color:#8C907E"></i>
            <div style="font-size:12px;font-weight:500;margin-top:5px">Click to open Media Manager — Upload images & videos to S3</div>
          </div>
          <div class="d-flex justify-content-end mt-3">
            <form method="POST" action="{{ route('admin.products.variants.destroy',$v->id) }}" onsubmit="return confirm('Delete this variant and all its S3 media?')">
              @csrf @method('DELETE')
              <button class="btn btn-outline-danger btn-sm text-uppercase" style="font-size:11px">Delete Variant</button>
            </form>
          </div>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:40px;color:#aaa;border:2px dashed #eee;border-radius:8px">
        <i class="bi bi-tags" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:10px"></i>
        No variants yet. Click "Add Variant" to start.
      </div>
      @endforelse

      @if($product->variants->count())
      <div class="sv-var-summary">
        <strong>Variant Summary</strong> · {{ $product->variants->count() }} option(s) ·
        Total stock: {{ $product->variants->sum('stock') }} ·
        Price range: {{ number_format($product->variants->min('price'),2) }}–{{ number_format($product->variants->max('price'),2) }} AED
      </div>
      @endif
    </div>
  </div>

  {{-- Right: Quick Info --}}
  <div class="col-lg-4">
    <div class="sv-card mb-4">
      <div class="sv-card-title">Product Info</div>
      <div style="font-size:12px;color:#aaa;line-height:2">
        <div>ID: <strong style="color:#333">{{ $product->id }}</strong></div>
        <div>Slug: <strong style="color:#333">{{ $product->slug }}</strong></div>
        <div>Views: <strong style="color:#333">{{ number_format($product->views) }}</strong></div>
        <div>Variants: <strong style="color:#333">{{ $product->variants->count() }}</strong></div>
        <div>Total Stock: <strong style="color:#333">{{ $product->variants->sum('stock') }}</strong></div>
        <div>Created: <strong style="color:#333">{{ $product->created_at->format('d M Y') }}</strong></div>
      </div>
      <a href="{{ route('product.show',$product->slug) }}" target="_blank" class="btn btn-outline-dark w-100 text-uppercase mt-3" style="font-size:11px;letter-spacing:1px">
        <i class="bi bi-box-arrow-up-right"></i> View on Store
      </a>
    </div>

    <div class="sv-card" style="background:#fafcfa;border-color:#d4edda">
      <div style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#2e7d52;margin-bottom:10px">S3 Upload Info</div>
      <div style="font-size:12px;color:#555;line-height:1.8">
        All media uploads directly to:<br>
        <code style="font-size:11px;background:#e9f5ef;padding:2px 6px;border-radius:3px;color:#2e7d52">s3://rajni-app-bucket-2026/stylevera/</code><br><br>
        • Variant media → <code style="font-size:11px">variants/{id}/</code><br>
        • Cover images → <code style="font-size:11px">products/{id}/cover/</code><br>
        • No page refresh needed
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function updateVariant(vid) {
  $.post('/admin/products/variants/' + vid, {
    _token: '{{ csrf_token() }}',
    _method: 'PUT',
    price: $('#vp_price_' + vid).val(),
    sale_price: $('#vp_sale_' + vid).val(),
    stock: $('#vp_stock_' + vid).val(),
    sku: $('#vp_sku_' + vid).val()
  }).done(function() {
    svToast('Variant updated!', 'success');
    setTimeout(() => location.reload(), 800);
  }).fail(function() { svToast('Error updating variant', 'error'); });
}
</script>
@endpush

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
