@props([
    'variant' => 'solid',
    'color'   => 'primary',
    'size'    => 'md',
    'checked' => false,
    'disabled' => false,
])

@php
    $colors = [
        'primary'   => 'var(--xushi-color-primary)',
        'secondary' => 'var(--xushi-color-secondary)',
        'success'   => 'var(--xushi-color-success)',
        'danger'    => 'var(--xushi-color-danger)',
        'warning'   => 'var(--xushi-color-warning)',
        'info'      => 'var(--xushi-color-info)',
    ];

    $sizes = [
            'xs' => ['track-w' => '28px', 'track-h' => '16px', 'thumb' => '12px', 'offset' => '2px'],
            'sm' => ['track-w' => '36px', 'track-h' => '20px', 'thumb' => '14px', 'offset' => '3px'],
            'md' => ['track-w' => '44px', 'track-h' => '24px', 'thumb' => '18px', 'offset' => '3px'],
            'lg' => ['track-w' => '56px', 'track-h' => '30px', 'thumb' => '24px', 'offset' => '3px'],
            'xl' => ['track-w' => '68px', 'track-h' => '36px', 'thumb' => '30px', 'offset' => '3px'],
        ];

    $sz     = $sizes[$size] ?? $sizes['md'];
    $accent = $colors[$color] ?? $colors['primary'];

    $trackInactiveBg = $variant === 'soft'
        ? 'color-mix(in oklch, ' . $accent . ' 80%, var(--xushi-color-primary))'
        : 'var(--xushi-color-base-neutral)';
    $trackActiveBg = $variant === 'soft'
        ? 'color-mix(in oklch, ' . $accent . ' 25%, var(--xushi-color-primary))'
        : $accent;

    $travelPx = (int) $sz['track-w'] - (int) $sz['thumb'] - 2 * (int) $sz['offset'];

    $trackStyle = collect([
        '--xushi-toggle-travel'   => $travelPx . 'px',
        'display'                 => 'inline-flex',
        'align-items'             => 'center',
        'width'                   => $sz['track-w'],
        'height'                  => $sz['track-h'],
        'border-radius'           => '999px',
        'position'                => 'relative',
        'cursor'                  => $disabled ? 'not-allowed' : 'pointer',
        'opacity'                 => $disabled ? '0.5' : '1',
        'transition'              => 'background 200ms ease',
        'background'              => $checked ? $trackActiveBg : $trackInactiveBg,
        'box-sizing'              => 'border-box',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');

    $thumbStyle = collect([
        'position'       => 'absolute',
        'top'            => $sz['offset'],
        'left'           => $sz['offset'],
        'width'          => $sz['thumb'],
        'height'         => $sz['thumb'],
        'border-radius'  => '999px',
        'background'     => '#ffffff',
        'transition'     => 'transform 180ms var(--ease-out-smooth)',
        'pointer-events' => 'none',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');
@endphp

@once
<style>
    .xushi-toggle {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        user-select: none;
    }

    .xushi-toggle-track {
        position: relative;
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        flex-shrink: 0;
        transition: background 150ms ease;
    }

    .xushi-toggle-track input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .xushi-toggle-thumb {
        position: relative;
        border-radius: 50%;
        background: currentColor;
        transition: transform 180ms cubic-bezier(0.4, 0, 0.2, 1), background 150ms ease;
        pointer-events: none;
        flex-shrink: 0;
    }

    .xushi-toggle-thumb.is-on {
        transform: translateX(var(--xushi-toggle-travel, 100%));
    }
</style>
@endonce

<label style="display:inline-flex; align-items:center; gap:0.75rem; cursor:{{ $disabled ? 'not-allowed' : 'pointer' }}; {{ $disabled ? 'opacity:0.5;' : '' }}" {{ $attributes->except('class') }}>
    <span
        class="xushi-toggle-track {{ $checked ? 'is-on' : '' }}"
        style="{{ $trackStyle }}"
        data-inactive-bg="{{ $trackInactiveBg }}"
        data-active-bg="{{ $trackActiveBg }}"
    >
        <input
            type="checkbox"
            style="position:absolute; opacity:0; width:0; height:0; pointer-events:none;"
            @checked($checked)
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->only(['name', 'id', 'value']) }}
            onchange="
                const track = this.parentElement;
                const thumb = track.querySelector('.xushi-toggle-thumb');
                const on = this.checked;
                track.classList.toggle('is-on', on);
                thumb.classList.toggle('is-on', on);
                track.style.background = on ? track.dataset.activeBg : track.dataset.inactiveBg;
            "
        >
        <span
            class="xushi-toggle-thumb {{ $checked ? 'is-on' : '' }}"
            style="{{ $thumbStyle }}"
        ></span>
    </span>
    @if($slot->isNotEmpty())
        <span style="font-size:0.875rem; color:var(--xushi-color-base-content);">{{ $slot }}</span>
    @endif
</label>