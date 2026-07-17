@php
    $hasDoc = $docs->isNotEmpty();
    $firstDoc = $hasDoc ? $docs->first() : null;
    
    // Determine which disk to use
    $disk = 'cloud';
    $cleanPath = $hasDoc ? str_replace('public/', '', $firstDoc->file_path) : null;
    $fileExists = false;
    
    if ($hasDoc) {
        // Try cloud first
        if (Storage::disk('cloud')->exists($cleanPath)) {
            $disk = 'cloud';
            $fileExists = true;
        } elseif (Storage::disk('public')->exists($firstDoc->file_path)) {
            // Fallback to public (old files)
            $disk = 'public';
            $fileExists = true;
        }
    }
    
    // Get metadata from the correct disk
    $isImage = false;
    $isPdf = false;
    $fileSize = 0;
    $fileSizeFormatted = null;
    $fileUrl = null;
    $uploadDate = $firstDoc ? $firstDoc->created_at->format('M d, Y') : null;
    
    if ($fileExists) {
        try {
            $mimeType = Storage::disk($disk)->mimeType($disk === 'cloud' ? $cleanPath : $firstDoc->file_path);
            $isImage = in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif']);
            $isPdf = $mimeType === 'application/pdf';
            $fileSize = Storage::disk($disk)->size($disk === 'cloud' ? $cleanPath : $firstDoc->file_path);
            $fileSizeFormatted = number_format($fileSize / 1024, 1) . ' KB';
            
            // ✅ Generate URL based on disk – DO NOT remove 'public/' prefix!
            if ($disk === 'cloud') {
                $fileUrl = Storage::disk('cloud')->url($cleanPath);
            } else {
                // ✅ Keep 'public/' prefix – it's the correct path inside public disk
                $fileUrl = Storage::disk('public')->url($firstDoc->file_path);
            }
        } catch (\Exception $e) {
            // If error, treat as missing
            $fileExists = false;
            $fileUrl = null;
        }
    }
    
    $downloadUrl = $hasDoc ? route('admin.registrations.downloadDocument', $firstDoc->id) : null;
    $fileTypeForModal = $isImage ? 'image' : ($isPdf ? 'pdf' : 'other');
@endphp

<div style="background:#f8fafc; border-radius:8px; padding:14px 16px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:14px; transition:0.2s;">
    {{-- Icon --}}
    <div style="width:40px; height:40px; background:{{ $fileExists ? '#e2e8f0' : '#f1f5f9' }}; border-radius:8px; display:flex; align-items:center; justify-content:center; color:{{ $fileExists ? '#0EA5E9' : '#94a3b8' }}; font-size:1.2rem;">
        <i class="fas {{ $icon }}"></i>
    </div>
    {{-- Info --}}
    <div style="flex:1; min-width:0;">
        <div style="font-weight:600; color:#0f172a; font-size:0.85rem;">{{ $label }}</div>
        @if($fileExists)
            <div style="display:flex; gap:12px; font-size:0.7rem; color:#64748b; margin-top:2px; flex-wrap:wrap;">
                <span>{{ $docs->count() }} file(s)</span>
                @if($fileSizeFormatted) <span>{{ $fileSizeFormatted }}</span> @endif
                @if($uploadDate) <span>{{ $uploadDate }}</span> @endif
                @if($disk === 'public') 
                    <span style="color:#f59e0b; background:#fef3c7; padding:0 6px; border-radius:4px; font-size:0.6rem;">Legacy</span>
                @endif
            </div>
        @else
            <div style="font-size:0.7rem; color:#94a3b8; margin-top:2px;">
                <i class="fas fa-times-circle" style="color:#dc2626;"></i> {{ __('messages.missing') }}
            </div>
        @endif
    </div>
    {{-- Actions --}}
    <div style="display:flex; gap:6px; flex-shrink:0;">
        @if($fileExists)
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