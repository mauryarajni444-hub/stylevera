@extends('layouts.admin')
@section('title','Add Category')
@section('content')
<div class="sv-card" style="max-width:600px">
<form method="POST" action="{{ route('admin.categories.store') }}">@csrf
<div class="row g-3">
  <div class="col-md-6"><label class="admin-label">Name EN *</label><input name="name_en" class="admin-input" required></div>
  <div class="col-md-6"><label class="admin-label">Name AR *</label><input name="name_ar" class="admin-input" dir="rtl" required></div>
  <div class="col-md-6"><label class="admin-label">Desc EN</label><input name="description_en" class="admin-input"></div>
  <div class="col-md-6"><label class="admin-label">Desc AR</label><input name="description_ar" class="admin-input" dir="rtl"></div>
  <div class="col-md-6"><label class="admin-label">Sort Order</label><input name="sort_order" type="number" class="admin-input" value="0"></div>
  <div class="col-md-6 d-flex gap-3 align-items-center pt-3">
    <label style="cursor:pointer;display:flex;gap:6px"><input type="checkbox" name="is_active" value="1" checked>Active</label>
    <label style="cursor:pointer;display:flex;gap:6px"><input type="checkbox" name="is_featured" value="1">Featured</label>
  </div>
  <div class="col-12"><button class="btn btn-dark text-uppercase">Create Category</button></div>
</div>
</form></div>
@endsection