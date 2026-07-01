@extends('layouts.public')

@section('title', __('messages.committee') . ' - HEAN')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<section style="padding-top:120px; background: linear-gradient(135deg, #0EA5E9, #3B82F6); color: white; text-align: center; padding-bottom:50px;">
    <div class="container">
        <h1 style="font-size:3rem; font-weight:800; margin-bottom:12px;">
            <i class="fas fa-users me-3"></i> @lang('messages.committee')
        </h1>
        <p style="font-size:1.2rem; opacity:0.9; max-width:600px; margin:0 auto;">
            Meet our executive committee members who are leading the hostel community.
        </p>
    </div>
</section>

{{-- ===== STATS BAR ===== --}}
<section style="padding:30px 0; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:20px; text-align:center;">
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#0EA5E9;">{{ $members->count() ?? 0 }}</div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">कुल सदस्य</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#22C55E;">
                    {{ $members->pluck('position')->unique()->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">पदहरू</div>
            </div>
            <div>
                <div style="font-size:2.2rem; font-weight:800; color:#8B5CF6;">
                    {{ $members->where('is_published', true)->count() ?? 0 }}
                </div>
                <div style="color:#64748b; font-size:0.9rem; font-weight:500;">सक्रिय सदस्य</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== COMMITTEE GRID ===== --}}
<section style="padding:60px 0; background:#ffffff;">
    <div class="container">

        {{-- Section Header --}}
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:2rem; font-weight:700; color:#0f172a; margin:0;">
                <i class="fas fa-handshake" style="color:#0EA5E9; margin-right:10px;"></i> हाम्रो कार्यसमिति
            </h2>
            <p style="color:#64748b; margin-top:4px; font-size:0.95rem;">
                हाम्रा कार्यसमिति सदस्यहरू जसले होस्टेल समुदायको नेतृत्व गरिरहेका छन्।
            </p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,1fr)); gap:30px;">
            @forelse($members as $member)
            <div class="committee-card" style="background:#fff; border-radius:20px; padding:30px 20px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.05); transition:transform 0.3s, box-shadow 0.3s; border:1px solid #f1f5f9; position:relative;">

                {{-- Image --}}
                <div style="position:relative; display:inline-block; margin-bottom:15px;">
                    <img src="{{ $member->image ? asset('storage/'.$member->image) : asset('images/avatar-placeholder.png') }}" 
                         alt="{{ $member->name }}" 
                         style="width:130px; height:130px; border-radius:50%; object-fit:cover; border:4px solid #e2e8f0; transition:border-color 0.3s;">
                    {{-- Badge or indicator --}}
                    @if($member->is_published)
                        <span style="position:absolute; bottom:4px; right:4px; width:16px; height:16px; background:#22C55E; border-radius:50%; border:3px solid #fff; display:block;"></span>
                    @endif
                </div>

                {{-- Name --}}
                <h3 style="font-size:1.2rem; font-weight:700; color:#0f172a; margin-bottom:4px;">
                    {{ $member->name }}
                </h3>

                {{-- Position --}}
                <div style="display:inline-block; background:linear-gradient(135deg, #0EA5E9, #3B82F6); color:#fff; padding:4px 16px; border-radius:50px; font-size:0.75rem; font-weight:600; margin-bottom:12px;">
                    {{ $member->position }}
                </div>

                {{-- Order / Serial (if needed) --}}
                @if($member->order)
                    <p style="color:#94a3b8; font-size:0.7rem; margin-bottom:8px;">
                        <i class="fas fa-hashtag"></i> क्रम: {{ $member->order }}
                    </p>
                @endif

                {{-- Social Links --}}
                <div style="display:flex; justify-content:center; gap:12px; margin-top:10px; padding-top:15px; border-top:1px solid #e2e8f0;">
                    @if($member->facebook)
                        <a href="{{ $member->facebook }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#1877F2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.9rem;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#0A66C2; color:#fff; border-radius:50%; text-decoration:none; transition:0.3s; font-size:0.9rem;">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if(!$member->facebook && !$member->linkedin)
                        <span style="color:#94a3b8; font-size:0.75rem;">कुनै सामाजिक लिङ्क छैन</span>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; background:#f8fafc; border-radius:20px;">
                <i class="fas fa-users" style="font-size:3rem; color:#cbd5e1; display:block; margin-bottom:15px;"></i>
                <p style="color:#94a3b8; font-size:1.1rem;">कुनै समिति सदस्य फेला परेन।</p>
            </div>
            @endforelse
        </div>

        {{-- Show only if members exist --}}
        @if($members->count() > 0)
            <div style="text-align:center; margin-top:30px;">
                <p style="color:#94a3b8; font-size:0.85rem;">
                    <i class="fas fa-info-circle"></i> 
                    कुल {{ $members->count() }} सदस्यहरू मध्ये {{ $members->where('is_published', true)->count() }} जना सक्रिय छन्।
                </p>
            </div>
        @endif
    </div>
</section>

{{-- ===== QR CODE SECTION ===== --}}
<section style="padding:50px 0; background:#f8fafc;">
    <div class="container">
        <div style="text-align:center; padding:40px 30px; background:#fff; border-radius:16px; border:2px dashed #0EA5E9; max-width:600px; margin:0 auto;">
            <div style="display:inline-block; background:#0EA5E9; color:#fff; padding:6px 20px; border-radius:50px; font-size:0.85rem; font-weight:600; margin-bottom:15px;">
                <i class="fas fa-qrcode me-2"></i> होस्टेल दर्ताको लागि QR Code
            </div>
            <h4 style="font-weight:700; color:#0f172a; margin-bottom:10px;">
                स्क्यान गर्नुहोस् र दर्ता गर्नुहोस्
            </h4>
            <p style="color:#64748b; font-size:0.95rem; max-width:400px; margin:0 auto 20px;">
                तपाईंको होस्टेल HEAN मा दर्ता गर्न मोबाइलको क्यामेरा प्रयोग गर्नुहोस्।
            </p>
            <div style="display:inline-block; background:#fff; padding:15px; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                <img src="{{ asset('images/qrcode.png') }}" alt="QR Code for Registration" style="width:180px; height:180px; display:block; margin:0 auto;">
            </div>
            <p style="color:#94a3b8; font-size:0.8rem; margin-top:12px;">
                <i class="fas fa-camera me-1"></i> QR स्क्यान गरेपछि दर्ता फारम खुल्नेछ
            </p>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Committee Card Hover Effects */
    .committee-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
        border-color: #0EA5E9 !important;
    }

    .committee-card:hover img {
        border-color: #0EA5E9 !important;
    }

    /* Social Icon Hover */
    .committee-card .social-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .committee-card {
            padding: 20px 15px !important;
        }
        .committee-card img {
            width: 100px !important;
            height: 100px !important;
        }
    }
</style>
@endpush