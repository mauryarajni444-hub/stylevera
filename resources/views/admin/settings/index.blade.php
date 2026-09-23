@extends('layouts.admin')
@section('title','Settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
  @csrf
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="sv-card mb-4">
        <div class="sv-card-title">General</div>
        <div class="row g-3">
          @foreach([['general.store_name_en','Store Name (EN)'],['general.store_name_ar','Store Name (AR)'],['general.email','Email'],['general.phone','Phone'],['general.address_en','Address (EN)'],['general.address_ar','Address (AR)'],['general.shipping_fee','Shipping Fee (AED)'],['general.free_shipping_above','Free Shipping Above (AED)']] as [$k,$label])
          <div class="col-12"><label class="admin-label">{{ $label }}</label><input name="settings[{{ $k }}]" class="admin-input" value="{{ $settings->get($k,'') }}" {{ str_contains($k,'_ar')?'dir=rtl':'' }}></div>
          @endforeach
        </div>
      </div>
      <div class="sv-card">
        <div class="sv-card-title">Announcements</div>
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Announcement (EN)</label><textarea name="settings[announcement_en.text]" class="admin-input" rows="3">{{ $settings->get('announcement_en.text','') }}</textarea></div>
          <div class="col-12"><label class="admin-label">Announcement (AR)</label><textarea name="settings[announcement_ar.text]" class="admin-input" rows="3" dir="rtl">{{ $settings->get('announcement_ar.text','') }}</textarea></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="sv-card">
        <div class="sv-card-title">Social Media</div>
        <div class="row g-3">
          @foreach([['social.instagram','Instagram URL'],['social.facebook','Facebook URL'],['social.twitter','Twitter URL'],['social.pinterest','Pinterest URL']] as [$k,$label])
          <div class="col-12"><label class="admin-label">{{ $label }}</label><input name="settings[{{ $k }}]" class="admin-input" value="{{ $settings->get($k,'') }}"></div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-12"><button class="btn btn-dark text-uppercase px-5">Save All Settings</button></div>
  </div>
</form>
@endsection