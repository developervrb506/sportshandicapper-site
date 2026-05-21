@extends('admin.layouts.admin')
@section('title', 'About Us - INSPIN Admin')
@section('page-title', 'About Us Page')

@section('content')
<div style="max-width:900px;">
    <form method="POST" action="{{ route('admin.about.update') }}">
        @csrf
        @method('PUT')

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h2>About Us Content</h2>
                <span style="font-size:12px;color:#94a3b8;">This content appears on the public About Us page</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Page Content</label>
                    <textarea name="about_content" id="aboutContent" class="form-control" rows="18">{{ old('about_content', $aboutContent) }}</textarea>
                    <div class="form-hint" style="margin-top:6px;">Use the editor to format headings, bold text, bullet lists, and more. Expert bios are pulled automatically from the Experts section below.</div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <h2>Expert Bios Preview</h2>
                <a href="{{ route('admin.experts.index') }}" class="btn btn-ghost btn-sm">Manage Experts</a>
            </div>
            <div class="card-body">
                <p style="font-size:13px;color:#64748b;margin-bottom:16px;">The expert bios section on the public About page is automatically generated from your active experts. Edit an expert's bio and photo in the <a href="{{ route('admin.experts.index') }}" style="color:#2563eb;">Experts</a> section.</p>
                @php $experts = \App\Models\Expert::where('is_active', true)->get(); @endphp
                @if($experts->isEmpty())
                    <p style="color:#94a3b8;font-size:13px;">No active experts yet. <a href="{{ route('admin.experts.create') }}" style="color:#2563eb;">Add one</a>.</p>
                @else
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;">
                    @foreach($experts as $expert)
                    <div style="display:flex;gap:12px;align-items:flex-start;padding:12px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;">
                        @if($expert->avatar)
                            <img src="{{ asset('storage/uploads/experts/'.$expert->avatar) }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                        @else
                            <div style="width:48px;height:48px;border-radius:50%;background:#dc2626;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
                        @endif
                        <div>
                            <div style="font-weight:700;font-size:14px;color:#0f172a;">{{ $expert->name }}</div>
                            @if($expert->specialty)<div style="font-size:12px;color:#dc2626;font-weight:600;margin-bottom:4px;">{{ $expert->specialty }}</div>@endif
                            @if($expert->bio)<div style="font-size:12px;color:#64748b;line-height:1.4;">{{ Str::limit($expert->bio, 80) }}</div>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                Save About Us Page
            </button>
            <a href="{{ route('about') }}" class="btn btn-ghost" target="_blank">Preview Public Page</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.getElementById('aboutContent'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', '|',
            'bulletedList', 'numberedList', '|',
            'blockQuote', 'link', '|',
            'undo', 'redo'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            ]
        }
    })
    .catch(error => console.error('CKEditor failed to load:', error));
</script>
@endpush
