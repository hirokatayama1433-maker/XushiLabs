@props([
    'variant' => 'solid',
    'color' => 'primary',
    'checked' => false,
    'disabled' => false,
])

@php
    $colors = [
        'primary' => 'var(--xushi-color-primary)',
        'secondary' => 'var(--xushi-color-secondary)',
        'success' => 'var(--xushi-color-success)',
        'danger' => 'var(--xushi-color-danger)',
        'warning' => 'var(--xushi-color-warning)',
        'info' => 'var(--xushi-color-info)',
    ];

    $accent = $colors[$color] ?? $colors['primary'];
    $trackInactiveBg = $variant === 'soft'
        ? 'color-mix(in oklch, ' . $accent . ' 80%, var(--xushi-color-base-300))'
        : 'var(--xushi-color-base-muted)';
    $trackActiveBg = $variant === 'soft'
        ? 'color-mix(in oklch, ' . $accent . ' 25%, var(--xushi-color-base-100))'
        : $accent;

    $trackStyle = collect([
        'display' => 'inline-flex',
        'align-items' => 'center',
        'width' => '44px',
        'height' => '24px',
        'border-radius' => '999px',
        'position' => 'relative',
        'cursor' => $disabled ? 'not-allowed' : 'pointer',
        'opacity' => $disabled ? '0.5' : '1',
        'transition' => 'background 200ms ease',
        'background' => $checked ? $trackActiveBg : $trackInactiveBg,
        'box-sizing' => 'border-box',
    ])->map(fn($value, $key) => "$key: $value")->implode('; ');

    $thumbStyle = collect([
        'position' => 'absolute',
        'top' => '3px',
        'left' => '3px',
        'width' => '18px',
        'height' => '18px',
        'border-radius' => '999px',
        'background' => '#ffffff',
        'transition' => 'transform 180ms var(--ease-out-smooth)',
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
