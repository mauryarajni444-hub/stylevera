@extends('layouts.admin')
@section('title','Orders')
@section('content')
<div class="sv-card mb-3">
  <form method="GET" class="d-flex gap-2 flex-wrap">
    <input name="search" class="admin-input" style="max-width:200px" placeholder="Ref / Email" value="{{ request('search') }}">
    <select name="status" class="admin-select" style="max-width:160px" onchange="this.form.submit()">
      <option value="">All Status</option>
      @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
      <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <button class="btn btn-dark text-uppercase" style="font-size:12px">Search</button>
  </form>
</div>
<div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
<thead><tr><th>Ref</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody>@foreach($orders as $o)
<tr>
  <td><strong>{{ $o->ref_number }}</strong></td>
  <td>{{ $o->guest_name }}<br><small style="color:#999">{{ $o->guest_email }}</small></td>
  <td><strong>{{ number_format($o->total,2) }} AED</strong></td>
  <td><span class="sv-badge sv-b-{{ $o->payment_status }}">{{ ucfirst($o->payment_status) }}</span></td>
  <td><span class="sv-badge sv-b-{{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
  <td style="color:#999">{{ $o->created_at->format('d M Y') }}</td>
  <td>
    <a href="{{ route('admin.orders.show',$o->id) }}" class="btn btn-sm btn-outline-dark" style="font-size:11px">View</a>
    <form method="POST" action="{{ route('admin.orders.destroy',$o->id) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
  </td>
</tr>@endforeach</tbody>
</table></div><div class="mt-3">{{ $orders->links() }}</div></div>
@endsection