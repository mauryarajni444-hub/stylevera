@extends('layouts.admin')
@section('title','Contacts')
@section('content')
<div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
<thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Read</th><th>Date</th><th></th></tr></thead>
<tbody>@foreach($contacts as $c)
<tr style="{{ !$c->is_read?'background:#fffbf0':'' }}">
  <td><strong>{{ $c->name }}</strong></td>
  <td style="color:#999">{{ $c->email }}</td>
  <td>{{ $c->subject }}</td>
  <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $c->message }}</td>
  <td><span class="sv-badge {{ $c->is_read?'sv-b-active':'sv-b-pending' }}">{{ $c->is_read?'Read':'New' }}</span></td>
  <td style="color:#999;white-space:nowrap">{{ $c->created_at->format('d M Y') }}</td>
  <td>
    @if(!$c->is_read)<form method="POST" action="{{ route('admin.contacts.read',$c->id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-outline-dark" style="font-size:11px">Mark Read</button></form>@endif
    <form method="POST" action="{{ route('admin.contacts.destroy',$c->id) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
  </td>
</tr>@endforeach</tbody>
</table></div><div class="mt-3">{{ $contacts->links() }}</div></div>
@endsection