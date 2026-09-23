@extends('layouts.admin')
@section('title','Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div></div>
  <a href="{{ route('admin.products.create') }}" class="btn btn-dark text-uppercase" style="font-size:12px">+ Add Product</a>
</div>
<div class="sv-card">
  <div style="overflow-x:auto">
    <table class="sv-table">
      <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Variants</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach($products as $p)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <img src="{{ asset($p->getCoverImage()) }}" style="width:40px;height:52px;object-fit:cover;border:1px solid #eee">
              <div><strong style="font-size:13px">{{ $p->name_en }}</strong><br><small style="color:#999">{{ $p->name_ar }}</small></div>
            </div>
          </td>
          <td style="color:#999">{{ $p->category?->name_en }}</td>
          <td><strong>{{ number_format($p->base_price,2) }} AED</strong></td>
          <td><span class="sv-badge sv-b-confirmed">{{ $p->variants_count }} variants</span></td>
          <td><span class="sv-badge {{ $p->is_active?'sv-b-active':'sv-b-inactive' }}">{{ $p->is_active?'Active':'Inactive' }}</span></td>
          <td>
            <a href="{{ route('admin.products.edit',$p->id) }}" class="btn btn-sm btn-success" style="font-size:11px;border-radius: 3px">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy',$p->id) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf<button class="btn btn-sm btn-outline-danger" style="font-size:11px;border-radius: 3px">Del</button></form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-3">{{ $products->links() }}</div>
</div>
@endsection
