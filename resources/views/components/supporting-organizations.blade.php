@props(['organizations' => []])

<section class="supporting-organizations" id="supporting-organizations">
    <div class="container">
        {{-- Section header --}}
        <div class="section-header">
            <h2>Supporting Organizations</h2>
            <p>
                HEAN proudly collaborates with trusted healthcare, technology, banking and business organizations to
                deliver greater value and exclusive benefits to its members.
            </p>
        </div>

        {{-- Scrolling marquee --}}
        <div class="scroll-container">
            <div class="scroll-track">
                {{-- First set --}}
                @foreach ($organizations as $org)
                    <a href="{{ $org['url'] }}" target="_blank" rel="noopener" class="partner-card">
                        <div class="card-inner">
                            <div class="logo-wrapper">
                                <img src="{{ $org['logo'] }}" alt="{{ $org['name'] }}" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h3 class="org-name">{{ $org['name'] }}</h3>
                                <span class="partner-type">{{ $org['partner_type'] }}</span>
                            </div>
                            {{-- External link icon (appears on hover) --}}
                            <span class="external-icon">↗</span>
                        </div>
                    </a>
                @endforeach

                {{-- Duplicate set for seamless loop --}}
                @foreach ($organizations as $org)
                    <a href="{{ $org['url'] }}" target="_blank" rel="noopener" class="partner-card">
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