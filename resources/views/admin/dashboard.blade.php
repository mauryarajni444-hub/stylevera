@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-dark"><i class="bi bi-bag" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val">{{ $stats['total_orders'] }}</div><div class="sv-stat-label">Total Orders</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-green"><i class="bi bi-currency-dollar" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val">{{ number_format($stats['total_revenue'],0) }}</div><div class="sv-stat-label">Revenue (AED)</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-blue"><i class="bi bi-tag" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val">{{ $stats['total_products'] }}</div><div class="sv-stat-label">Products</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-orange"><i class="bi bi-clock" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val">{{ $stats['pending_orders'] }}</div><div class="sv-stat-label">Pending Orders</div></div></div></div>
</div>
<div class="sv-card">
  <div class="sv-card-title">Recent Orders</div>
  <div style="overflow-x:auto">
    <table class="sv-table">
      <thead><tr><th>Ref</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
        @foreach($recentOrders as $o)
        <tr>
          <td><strong>{{ $o->ref_number }}</strong></td>
          <td>{{ $o->guest_name }}</td>
          <td><strong>{{ number_format($o->total,2) }} AED</strong></td>
          <td><span class="sv-badge sv-b-{{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
          <td style="color:#999">{{ $o->created_at->format('d M Y') }}</td>
          <td><a href="{{ route('admin.orders.show',$o->id) }}" class="btn btn-sm btn-outline-dark" style="font-size:11px">View</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
