@extends('layouts.admin')
@section('title','Admin Users')
@section('content')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="sv-card">
      <div class="sv-card-title">Create Admin User</div>
      <form method="POST" action="{{ route('admin.users.store') }}">@csrf
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Name</label><input name="name" class="admin-input" required></div>
          <div class="col-12"><label class="admin-label">Email</label><input name="email" type="email" class="admin-input" required></div>
          <div class="col-12"><label class="admin-label">Password</label><input name="password" type="password" class="admin-input" required minlength="8"></div>
          <div class="col-12"><label class="admin-label">Role</label><select name="role" class="admin-select"><option value="admin">Admin</option><option value="master_admin">Master Admin</option></select></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100">Create Admin</button></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-7"><div class="sv-card"><table class="sv-table">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
    <tbody>@foreach($users as $u)
    <tr>
      <td><strong>{{ $u->name }}</strong></td>
      <td style="color:#999">{{ $u->email }}</td>
      <td><span class="sv-badge {{ $u->role==='master_admin'?'sv-b-blue':'sv-b-confirmed' }}">{{ ucfirst($u->role) }}</span></td>
      <td><span class="sv-badge {{ $u->is_active?'sv-b-active':'sv-b-inactive' }}">{{ $u->is_active?'Active':'Off' }}</span></td>
      <td>
        @if($u->id !== auth()->id())
        <form method="POST" action="{{ route('admin.users.destroy',$u->id) }}" onsubmit="return confirm('Delete?')">@csrf@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
        @else<small style="color:#999">You</small>@endif
      </td>
    </tr>@endforeach</tbody>
  </table><div class="mt-3">{{ $users->links() }}</div></div></div>
</div>
@endsection