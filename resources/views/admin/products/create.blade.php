@extends('layouts.admin')
@section('title','Add Product')
@section('content')
<div class="sv-card">
  <form method="POST" action="{{ route('admin.products.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6"><label class="admin-label">Name (EN) *</label><input name="name_en" class="admin-input" required></div>
      <div class="col-md-6"><label class="admin-label">Name (AR) *</label><input name="name_ar" class="admin-input" dir="rtl" required></div>
      <div class="col-md-4"><label class="admin-label">Category</label><select name="category_id" class="admin-select"><option value="">-- Select --</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name_en }}</option>@endforeach</select></div>
      <div class="col-md-4"><label class="admin-label">Base Price (AED) *</label><input name="base_price" type="number" step="0.01" class="admin-input" required></div>
      <div class="col-md-4"><label class="admin-label">Sale Price (AED)</label><input name="sale_price" type="number" step="0.01" class="admin-input"></div>
      <div class="col-md-4"><label class="admin-label">Gender</label><select name="gender" class="admin-select"><option value="unisex">Unisex</option><option value="women">Women</option><option value="men">Men</option><option value="kids">Kids</option></select></div>
      <div class="col-md-8"><label class="admin-label">Short Description (EN)</label><input name="short_desc_en" class="admin-input"></div>
      <div class="col-12"><label class="admin-label">Short Description (AR)</label><input name="short_desc_ar" class="admin-input" dir="rtl"></div>
      <div class="col-md-3 d-flex align-items-center gap-2"><input type="checkbox" name="is_active" value="1" checked id="chkActive"><label for="chkActive">Active</label></div>
      <div class="col-md-3 d-flex align-items-center gap-2"><input type="checkbox" name="is_featured" value="1" id="chkFeat"><label for="chkFeat">Featured</label></div>
      <div class="col-md-3 d-flex align-items-center gap-2"><input type="checkbox" name="is_new_arrival" value="1" id="chkNew"><label for="chkNew">New Arrival</label></div>
      <div class="col-md-3 d-flex align-items-center gap-2"><input type="checkbox" name="is_best_seller" value="1" id="chkBest"><label for="chkBest">Best Seller</label></div>
      <div class="col-12"><button class="btn btn-dark text-uppercase">Create Product & Add Variants →</button></div>
    </div>
  </form>
</div>
@endsection
