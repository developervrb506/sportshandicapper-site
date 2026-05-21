@extends('admin.layouts.admin')
@section('title', ($expert->exists ? 'Edit Expert' : 'New Expert') . ' - INSPIN Admin')
@section('page-title', $expert->exists ? 'Edit Expert' : 'New Expert')

@section('content')
<div style="max-width:640px;">
    <form method="POST"
          action="{{ $expert->exists ? route('admin.experts.update', $expert) : route('admin.experts.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($expert->exists) @method('PUT') @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Expert Profile</h2></div>
            <div class="card-body">
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $expert->name) }}" placeholder="Full name">
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Specialty</label>
                        <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $expert->specialty) }}" placeholder="e.g. NFL, NBA, Sharp Money">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Bio</label>
                    <textarea name="bio" class="form-control" rows="4" placeholder="Expert background and credentials…">{{ old('bio', $expert->bio) }}</textarea>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Avatar / Photo</label>
                    <input type="file" name="avatar" class="form-control" accept="image/*" onchange="previewImg(this,'avatarPreview')">
                    @if($expert->avatar)
                        <img id="avatarPreview" src="{{ asset('storage/'.$expert->avatar) }}" class="img-preview" style="width:72px;height:72px;border-radius:50%;">
                    @else
                        <img id="avatarPreview" src="" class="img-preview" style="width:72px;height:72px;border-radius:50%;display:none;">
                    @endif
                    @error('avatar')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <label class="form-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $expert->is_active ?? true) ? 'checked' : '' }}>
                    Active (visible on site)
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                {{ $expert->exists ? 'Update Expert' : 'Create Expert' }}
            </button>
            <a href="{{ route('admin.experts.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
