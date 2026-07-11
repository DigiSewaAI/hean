@php
    // $type = document type string (e.g., 'pan_certificate')
    // $docs = collection of documents for that type
    // $label = human readable label
    // $icon = FontAwesome icon class
    $hasDoc = $docs->isNotEmpty();
    $firstDoc = $hasDoc ? $docs->first() : null;
    $isImage = $hasDoc && in_array(Storage::disk('public')->mimeType($firstDoc->file_path), ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
    $isPdf = $hasDoc && Storage::disk('public')->mimeType($firstDoc->file_path) === 'application/pdf';
    $fileSize = $hasDoc ? Storage::disk('public')->size($firstDoc->file_path) : 0;
    $fileSizeFormatted = $fileSize ? number_format($fileSize / 1024, 1) . ' KB' : null;
    $uploadDate = $firstDoc ? $firstDoc->created_at->format('M d, Y') : null;
    $fileUrl = $hasDoc ? asset('storage/' . $firstDoc->file_path) : null;
    $downloadUrl = $hasDoc ? route('admin.documents.download', $firstDoc->id) : null;
    $fileTypeForModal = $isImage ? 'image' : ($isPdf ? 'pdf' : 'other');
@endphp

<div style="background:#f8fafc; border-radius:8px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px; transition:0.2s;">
    {{-- Icon --}}
    <div style="width:40px; height:40px; background:{{ $hasDoc ? '#e2e8f0' : '#f1f5f9' }}; border-radius:8px; display:flex; align-items:center; justify-content:center; color:{{ $hasDoc ? '#0EA5E9' : '#94a3b8' }}; font-size:1.2rem;">
        <i class="fas {{ $icon }}"></i>
    </div>
    {{-- Info --}}
    <div style="flex:1; min-width:0;">
        <div style="font-weight:600; color:#0f172a; font-size:0.85rem;">{{ $label }}</div>
        @if($hasDoc)
            <div style="display:flex; gap:12px; font-size:0.7rem; color:#64748b; margin-top:2px; flex-wrap:wrap;">
                <span>{{ $docs->count() }} file(s)</span>
                @if($fileSizeFormatted) <span>{{ $fileSizeFormatted }}</span> @endif
                @if($uploadDate) <span>{{ $uploadDate }}</span> @endif
            </div>
        @else
            <div style="font-size:0.7rem; color:#94a3b8; margin-top:2px;">
                <i class="fas fa-times-circle" style="color:#dc2626;"></i> {{ __('messages.missing') }}
            </div>
        @endif
    </div>
    {{-- Actions --}}
    <div style="display:flex; gap:6px; flex-shrink:0;">
        @if($hasDoc)
            @if($isImage || $isPdf)
                <button type="button" class="btn btn-sm btn-outline-primary" style="padding:4px 10px; font-size:0.7rem; border-radius:6px;"
                        data-bs-toggle="modal" data-bs-target="#docPreviewModal"
                        data-file-url="{{ $fileUrl }}"
                        data-file-type="{{ $fileTypeForModal }}"
                        data-file-name="{{ $label }}">
                    <i class="fas fa-eye"></i> {{ __('messages.view') }}
                </button>
            @else
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary" style="padding:4px 10px; font-size:0.7rem; border-radius:6px;">
                    <i class="fas fa-eye"></i> {{ __('messages.view') }}
                </a>
            @endif
            <a href="{{ $downloadUrl }}" class="btn btn-sm btn-outline-success" style="padding:4px 10px; font-size:0.7rem; border-radius:6px;">
                <i class="fas fa-download"></i> {{ __('messages.download') }}
            </a>
        @else
            <button class="btn btn-sm btn-outline-secondary" style="padding:4px 10px; font-size:0.7rem; border-radius:6px; opacity:0.5;" disabled>
                <i class="fas fa-eye-slash"></i> {{ __('messages.view') }}
            </button>
            <button class="btn btn-sm btn-outline-secondary" style="padding:4px 10px; font-size:0.7rem; border-radius:6px; opacity:0.5;" disabled>
                <i class="fas fa-download"></i> {{ __('messages.download') }}
            </button>
        @endif
    </div>
</div>