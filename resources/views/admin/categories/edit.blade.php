@extends('layouts.admin')
@section('title','Edit Category')
@section('content')
    <div class="sv-card" style="max-width:680px">
        <form method="POST" action="{{ route('admin.categories.update',$category) }}">@csrf@method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="admin-label">Name EN *</label><input name="name_en" class="admin-input" value="{{ $category->name_en }}" required></div>
                <div class="col-md-6"><label class="admin-label">Name AR *</label><input name="name_ar" class="admin-input" value="{{ $category->name_ar }}" dir="rtl" required></div>
                <div class="col-12">
                    <label class="admin-label">Category Image (S3)</label>
                    @if($category->image)<img src="{{ $category->image }}" id="svCatImgPrev" style="width:100px;height:100px;object-fit:cover;border:1px solid #ddd;margin-bottom:8px">@else<img src="" id="svCatImgPrev" style="display:none;width:100px;height:100px;object-fit:cover;border:1px solid #ddd;margin-bottom:8px">@endif
                    <div class="upload-zone" onclick="document.getElementById('svCatImgInput').click()">
                        <i class="bi bi-image" style="font-size:1.3rem;color:#8C907E"></i><br><small>Click to upload (JPG/PNG · max 5MB)</small>
                        <input type="file" id="svCatImgInput" accept="image/*" style="display:none" onchange="uploadCatImg(this.files,{{ $category->id }})">
                    </div>
                    <div style="font-size:11px;color:#999;margin-top:4px" id="svCatImgUrl">{{ $category->image ?: 'No image set' }}</div>
                </div>
                <div class="col-md-6 d-flex gap-3 align-items-center">
                    <label style="cursor:pointer;display:flex;gap:6px"><input type="checkbox" name="is_active" value="1" {{ $category->is_active?'checked':'' }}>Active</label>
                    <label style="cursor:pointer;display:flex;gap:6px"><input type="checkbox" name="is_featured" value="1" {{ $category->is_featured?'checked':'' }}>Featured</label>
                </div>
                <div class="col-12"><button class="btn btn-dark text-uppercase">Save Category</button></div>
            </div>
        </form></div>
@endsection
@push('scripts')
    <script>
        function uploadCatImg(files, catId) {
            if (!files.length) return;
            const fd = new FormData(); fd.append('file', files[0]); fd.append('_token', '{{ csrf_token() }}');
            svToast('Uploading...','info');
            $.ajax({ url: '/admin/categories/'+catId+'/image', method:'POST', data: fd, processData:false, contentType:false })
                .done(function(d){ if(d.success){ $('#svCatImgPrev').attr('src',d.url).show(); $('#svCatImgUrl').text(d.url); svToast('Image uploaded!','success'); } else svToast(d.message,'error'); });
        }
    </script>
@endpush
