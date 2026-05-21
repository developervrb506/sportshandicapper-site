@extends('admin.layouts.admin')
@section('title', ($package->exists ? 'Edit Package' : 'New Package') . ' - INSPIN Admin')
@section('page-title', $package->exists ? 'Edit Package' : 'New Package')

@section('content')
<div style="max-width:640px;">
    <form method="POST"
          action="{{ $package->exists ? route('admin.whale-packages.update', $package) : route('admin.whale-packages.store') }}">
        @csrf
        @if($package->exists) @method('PUT') @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Package Details</h2></div>
            <div class="card-body">
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $package->title) }}" placeholder="e.g. Whale Monthly">
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Package description shown to members…">{{ old('description', $package->description) }}</textarea>
                </div>
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Price (USD) <span class="required">*</span></label>
                        <input type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price', $package->price) }}" placeholder="e.g. 99.00">
                        @error('price')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Duration Label</label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration', $package->duration) }}" placeholder="e.g. 1 Month, 3 Months">
                    </div>
                    <div class="form-group">
                        <label>Duration (days)</label>
                        <input type="number" name="duration_days" min="1" class="form-control" value="{{ old('duration_days', $package->duration_days) }}" placeholder="e.g. 30">
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $package->sort_order) }}" placeholder="e.g. 1, 2, 3">
                        <div class="form-hint">Lower numbers appear first.</div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Features</label>
                    <textarea name="features" class="form-control" rows="6" placeholder="One feature per line:&#10;Access to all picks&#10;Discord community&#10;Email alerts">{{ old('features', is_array($package->features) ? implode("\n", $package->features) : $package->features) }}</textarea>
                    <div class="form-hint">One feature per line — each becomes a bullet point on the package card.</div>
                </div>
                <label class="form-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
                    Active (visible on site)
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                {{ $package->exists ? 'Update Package' : 'Create Package' }}
            </button>
            <a href="{{ route('admin.whale-packages.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
