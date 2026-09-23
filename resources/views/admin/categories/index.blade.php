@extends('layouts.admin')
@section('title','Categories')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4"><div></div><a href="{{ route('admin.categories.create') }}" class="btn btn-dark text-uppercase" style="font-size:12px">+ Add Category</a></div>
    <div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
                <thead><tr><th>Image</th><th>Name EN</th><th>Name AR</th><th>Products</th><th>Status</th><th></th></tr></thead>
                <tbody>@foreach($categories as $c)
                    <tr>
                        <td>@if($c->image)<img src="{{ $c->image }}" style="width:40px;height:40px;object-fit:cover">@else<div style="width:40px;height:40px;background:#f1f1f0;border-radius:4px"></div>@endif</td>
                        <td><strong>{{ $c->name_en }}</strong></td><td dir="rtl">{{ $c->name_ar }}</td>
                        <td>{{ $c->products_count }}</td>
                        <td><span class="sv-badge {{ $c->is_active?'sv-b-active':'sv-b-inactive' }}">{{ $c->is_active?'Active':'Inactive' }}</span></td>
                        <td>
                            <a href="{{ route('admin.categories.edit',$c) }}" class="btn btn-sm btn-success" style="font-size:11px">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
                        </td>
                    </tr>@endforeach</tbody>
            </table></div><div class="mt-3">{{ $categories->links() }}</div></div>
@endsection
