@props([
    'title' => null,
    'timestamp' => null,
    'color' => 'primary',
    'icon' => null,
    'last' => false,
])

@php
    $dotColors = [
        'primary' => 'var(--xushi-color-primary)',
        'success' => 'var(--xushi-color-success)',
        'danger'  => 'var(--xushi-color-danger)',
        'warning' => 'var(--xushi-color-warning)',
        'info'    => 'var(--xushi-color-info)',
        'base'    => 'var(--xushi-color-base-content)',
    ];
    $dotColor = $dotColors[$color] ?? $dotColors['primary'];
@endphp

<div class="xushi-timeline-item" style="display:flex; gap:1rem; position:relative; padding-bottom:{{ $last ? '0' : '1.5rem' }};">

    {{-- Left column: dot + line --}}
    <div style="display:flex; flex-direction:column; align-items:center; flex-shrink:0; width:1.5rem;">
        {{-- Dot / Icon --}}
        <div style="
            width:1.5rem;
            height:1.5rem;
            border-radius:999px;
            background:{{ $dotColor }};
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
            z-index:1;
            box-shadow: 0 0 0 3px color-mix(in oklch, {{ $dotColor }} 20%, transparent);
        ">
            @if($icon)
                <xushi:icon :name="$icon" size="0.75rem" color="#fff" />
            @elseif(isset($iconslot))
                {{ $iconslot }}
            @endif
        </div>

        {{-- Line --}}
        @if(!$last)
            <div style="flex:1; width:2px; background:var(--xushi-color-base-border); margin-top:0.25rem; border-radius:9999px;"></div>
        @endif
    </div>

    {{-- Right column: content --}}
    <div style="flex:1; min-width:0; padding-top:0.125rem;">
        @if($title || $timestamp)
            <div style="display:flex; align-items:baseline; justify-content:space-between; gap:0.5rem; margin-bottom:0.25rem;">
                @if($title)
                    <span style="font-size:0.9375rem; font-weight:600; color:var(--xushi-color-base-content); line-height:1.3;">{{ $title }}</span>
                @endif
                @if($timestamp)
                    <span style="font-size:0.75rem; color:var(--xushi-color-base-content-muted); white-space:nowrap; flex-shrink:0;">{{ $timestamp }}</span>
                @endif
            </div>
        @endif

        <div style="font-size:0.875rem; line-height:1.6; color:var(--xushi-color-base-content-muted);">
            {{ $slot }}
        </div>
    </div>

</div>
