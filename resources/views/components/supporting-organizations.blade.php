@props(['organizations' => []])

{{-- Self-contained styles (embedded) --}}
<style>
    /* Force horizontal layout & animation */
    .supporting-organizations {
        padding: 80px 0;
        background: #f8fafc;
        overflow: hidden;
    }

    .supporting-organizations .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .supporting-organizations .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .supporting-organizations .section-header p {
        color: #64748b;
        max-width: 640px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .supporting-organizations .scroll-container {
        overflow: hidden !important;
        position: relative;
        width: 100%;
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }

    .supporting-organizations .scroll-track {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        gap: 30px;
        width: max-content !important;
        animation: scroll-partners 45s linear infinite;
        will-change: transform;
    }

    .supporting-organizations .scroll-container:hover .scroll-track {
        animation-play-state: paused;
    }

    .supporting-organizations .partner-card {
        flex: 0 0 auto !important;
        width: 260px !important;
        background: #ffffff;
        border-radius: 20px;
        padding: 20px 18px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        cursor: pointer;
        position: relative;
    }

    .supporting-organizations .partner-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
    }

    .supporting-organizations .card-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
    }

    .supporting-organizations .logo-wrapper {
        height: 60px;
        width: 140px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .supporting-organizations .logo-wrapper img {
        max-height: 60px;
        max-width: 140px;
        width: auto;
        height: auto;
        object-fit: contain;
        transition: filter 0.3s;
    }

    .supporting-organizations .partner-card:hover .logo-wrapper img {
        filter: brightness(1.05);
    }

    .supporting-organizations .org-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
        line-height: 1.3;
    }

    .supporting-organizations .partner-type {
        font-size: 0.75rem;
        font-weight: 500;
        color: #334155;
        background: rgba(14, 165, 233, 0.06);
        padding: 4px 14px;
        border-radius: 30px;
        letter-spacing: 0.02em;
        display: inline-block;
        margin-top: 4px;
    }

    .supporting-organizations .external-icon {
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 1rem;
        color: #94a3b8;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        transform: translateY(-4px);
    }

    .supporting-organizations .partner-card:hover .external-icon {
        opacity: 1;
        transform: translateY(0);
    }

    @keyframes scroll-partners {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @media (max-width: 992px) {
        .supporting-organizations .partner-card {
            width: 220px !important;
            padding: 16px 14px;
        }
        .supporting-organizations .logo-wrapper {
            height: 50px;
            width: 120px;
        }
        .supporting-organizations .logo-wrapper img {
            max-height: 50px;
            max-width: 120px;
        }
        .supporting-organizations .org-name {
            font-size: 1rem;
        }
    }

    @media (max-width: 768px) {
        .supporting-organizations .partner-card {
            width: 180px !important;
            padding: 14px 12px;
        }
        .supporting-organizations .logo-wrapper {
            height: 40px;
            width: 100px;
        }
        .supporting-organizations .logo-wrapper img {
            max-height: 40px;
            max-width: 100px;
        }
        .supporting-organizations .org-name {
            font-size: 0.9rem;
        }
        .supporting-organizations .partner-type {
            font-size: 0.65rem;
            padding: 3px 10px;
        }
        .supporting-organizations .scroll-track {
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .supporting-organizations .partner-card {
            width: 150px !important;
            padding: 12px 10px;
        }
        .supporting-organizations .logo-wrapper {
            height: 35px;
            width: 80px;
        }
        .supporting-organizations .logo-wrapper img {
            max-height: 35px;
            max-width: 80px;
        }
        .supporting-organizations .scroll-track {
            gap: 16px;
        }
    }
</style>

<section class="supporting-organizations" id="supporting-organizations">
    <div class="container">
        <div class="section-header">
    <h2>{{ __('messages.supporting_org_title') }}</h2>
    <p>{{ __('messages.supporting_org_desc') }}</p>
</div>

        <div class="scroll-container">
            <div class="scroll-track" style="display:flex !important; flex-direction:row !important; flex-wrap:nowrap !important; align-items:center !important; gap:30px; width:max-content !important; animation:scroll-partners 45s linear infinite !important;">
                {{-- First set --}}
                @foreach ($organizations as $org)
                    <a href="{{ $org['url'] }}" target="_blank" rel="noopener" class="partner-card" style="flex:0 0 auto !important; width:260px !important;">
                        <div class="card-inner">
                            <div class="logo-wrapper">
                                <img src="{{ $org['logo'] }}" alt="{{ $org['name'] }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h3 class="org-name">{{ $org['name'] }}</h3>
                                <span class="partner-type">{{ $org['partner_type'] }}</span>
                            </div>
                            <span class="external-icon">↗</span>
                        </div>
                    </a>
                @endforeach

                {{-- Duplicate set for seamless loop --}}
                @foreach ($organizations as $org)
                    <a href="{{ $org['url'] }}" target="_blank" rel="noopener" class="partner-card" style="flex:0 0 auto !important; width:260px !important;">
                        <div class="card-inner">
                            <div class="logo-wrapper">
                                <img src="{{ $org['logo'] }}" alt="{{ $org['name'] }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h3 class="org-name">{{ $org['name'] }}</h3>
                                <span class="partner-type">{{ $org['partner_type'] }}</span>
                            </div>
                            <span class="external-icon">↗</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>