@extends('layouts.admin')
@section('title','Banners')
@section('content')
<div class="row g-4">
  <div class="col-lg-5">
    <div class="sv-card">
      <div class="sv-card-title">Add Banner</div>
      <form method="POST" action="{{ route('admin.banners.store') }}">@csrf
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Title EN</label><input name="title_en" class="admin-input"></div>
          <div class="col-12"><label class="admin-label">Title AR</label><input name="title_ar" class="admin-input" dir="rtl"></div>
          <div class="col-12"><label class="admin-label">Subtitle EN</label><input name="subtitle_en" class="admin-input"></div>
          <div class="col-12"><label class="admin-label">Image URL (or upload below) *</label><input name="image" class="admin-input" id="svBannerUrl" placeholder="/images/banner-image-1.jpg" required></div>
          <div class="col-12"><label class="admin-label">Link</label><input name="link" class="admin-input" placeholder="/shop"></div>
          <div class="col-md-6"><label class="admin-label">Position</label><select name="position" class="admin-select"><option value="hero">Hero</option><option value="promo">Promo</option></select></div>
          <div class="col-md-6"><label class="admin-label">Sort Order</label><input name="sort_order" type="number" class="admin-input" value="0"></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100">Add Banner</button></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-7"><div class="sv-card"><table class="sv-table">
    <thead><tr><th>Image</th><th>Title</th><th>Position</th><th>Status</th><th></th></tr></thead>
    <tbody>@foreach($banners as $b)
    <tr>
      <td><img src="{{ $b->image }}" style="width:60px;height:40px;object-fit:cover"></td>
      <td>{{ $b->title_en }}</td>
      <td>{{ $b->position }}</td>
      <td><span class="sv-badge {{ $b->is_active?'sv-b-active':'sv-b-inactive' }}">{{ $b->is_active?'Active':'Off' }}</span></td>
      <td>
        <div class="upload-zone" style="padding:6px;font-size:11px" onclick="document.getElementById('svBI_{{ $b->id }}').click()">Upload New
          <input type="file" id="svBI_{{ $b->id }}" accept="image/*" style="display:none" onchange="uploadBannerImg(this.files,{{ $b->id }})">
        </div>
        <form method="POST" action="{{ route('admin.banners.destroy',$b->id) }}" onsubmit="return confirm('Delete?')" style="margin-top:4px">@csrf<button class="btn btn-sm btn-outline-danger w-100" style="font-size:11px">Del</button></form>
      </td>
    </tr>@endforeach</tbody>
  </table><div class="mt-3">{{ $banners->links() }}</div></div></div>
</div>
@endsection
@push('scripts')
<script>
function uploadBannerImg(files, bid) {
  if (!files.length) return;
  const fd = new FormData(); fd.append('file', files[0]); fd.append('_token', '{{ csrf_token() }}');
  svToast('Uploading...','info');
  $.ajax({ url: '/admin/banners/'+bid+'/image', method:'POST', data:fd, processData:false, contentType:false })
    .done(function(d){ if(d.success){ svToast('Image uploaded! Refresh to see.','success'); } else svToast(d.message,'error'); });
}
</script>
@endpush
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
