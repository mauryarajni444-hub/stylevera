@extends('layouts.admin')
@section('title','Coupons')
@section('content')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="sv-card">
      <div class="sv-card-title">Add Coupon</div>
      <form method="POST" action="{{ route('admin.coupons.store') }}">@csrf
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Code</label><input name="code" class="admin-input" placeholder="STYLEVERA10" required></div>
          <div class="col-md-6"><label class="admin-label">Type</label><select name="type" class="admin-select"><option value="percent">Percent (%)</option><option value="fixed">Fixed (AED)</option></select></div>
          <div class="col-md-6"><label class="admin-label">Value</label><input name="value" type="number" step="0.01" class="admin-input" required></div>
          <div class="col-md-6"><label class="admin-label">Min Order (AED)</label><input name="min_order" type="number" step="0.01" class="admin-input" value="0"></div>
          <div class="col-md-6"><label class="admin-label">Max Uses</label><input name="max_uses" type="number" class="admin-input" placeholder="Unlimited"></div>
          <div class="col-md-6"><label class="admin-label">Expires At</label><input name="expires_at" type="date" class="admin-input"></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100">Create Coupon</button></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-7"><div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
    <thead><tr><th>Code</th><th>Type</th><th>Value</th><th>Used</th><th>Expires</th><th>Status</th><th></th></tr></thead>
    <tbody>@foreach($coupons as $c)
    <tr>
      <td><strong>{{ $c->code }}</strong></td>
      <td>{{ $c->type }}</td>
      <td>{{ $c->type==='percent'?$c->value.'%':number_format($c->value,2).' AED' }}</td>
      <td>{{ $c->used_count }}@if($c->max_uses)/{{ $c->max_uses }}@endif</td>
      <td style="color:#999">{{ $c->expires_at?->format('d M Y') ?? 'Never' }}</td>
      <td><span class="sv-badge {{ $c->is_active?'sv-b-active':'sv-b-inactive' }}">{{ $c->is_active?'Active':'Off' }}</span></td>
      <td><form method="POST" action="{{ route('admin.coupons.destroy',$c->id) }}" onsubmit="return confirm('Delete?')">@csrf@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form></td>
    </tr>@endforeach</tbody>
  </table></div><div class="mt-3">{{ $coupons->links() }}</div></div></div>
</div>
@endsection