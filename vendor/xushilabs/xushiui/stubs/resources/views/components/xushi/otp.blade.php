@props([
    'length' => 6,
    'variant' => 'outline',
    'color' => 'base',
    'type' => 'numeric',
    'name' => null,
    'disabled' => false,
    'autofocus' => false,
    'size' => 'md',
    'radius' => 'var(--xushi-radius-field)',
    'gap' => null,
    'margin' => null,
    'shadow' => null,
])

@php
    $sizes = [
        'sm' => ['width' => '2.25rem', 'height' => '2.25rem', 'font-size' => '0.9375rem'],
        'md' => ['width' => '2.75rem', 'height' => '2.75rem', 'font-size' => '1.125rem'],
        'lg' => ['width' => '3.25rem', 'height' => '3.25rem', 'font-size' => '1.375rem'],
    ];

    $variantStyles = [
        'outline' => [
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
            'success' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-success)'],
            'danger' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-danger)'],
        ],
        'soft' => [
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $sz = $sizes[$size] ?? $sizes['md'];
    $resolved = $variantStyles[$variant][$color] ?? $variantStyles[$variant]['base'] ?? $variantStyles['outline']['base'];

    $style = collect([
        'display' => 'flex',
        'align-items' => 'center',
        'gap' => $gap ?? '0.5rem',
        'margin' => $margin,
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $boxStyle = collect(array_merge($sz, [
        'border-radius' => $radius,
        'border-width' => 'var(--xushi-border-field)',
        'border-style' => 'solid',
        'box-shadow' => $shadow,
        'text-align' => 'center',
        'font-weight' => '600',
        'font-family' => 'inherit',
        'caret-color' => 'var(--xushi-color-primary)',
        'transition' => 'border-color 150ms ease, box-shadow 150ms ease, background 150ms ease',
        'box-sizing' => 'border-box',
        'outline' => 'none',
        'opacity' => $disabled ? '0.5' : null,
    ], $resolved))->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $inputMode = match($type) {
        'numeric' => 'numeric',
        'alphanumeric' => 'text',
        'password' => 'text',
        default => 'text',
    };
    $inputType = $type === 'password' ? 'password' : 'text';
    $pattern = $type === 'numeric' ? '[0-9]' : '[A-Za-z0-9]';
@endphp

<div
    x-data="xushiOtp({
        length: {{ $length }},
        type: '{{ $type }}',
        name: {{ $name ? json_encode($name) : 'null' }}
    })"
    class="xushi-otp"
    style="{{ $style }}"
    {{ $attributes->except(['class', 'style']) }}
>
    {{-- Hidden combined input for form submission --}}
    @if($name)
        <input type="hidden" :name="{{ json_encode($name) }}" :value="getValue()">
    @endif

    {{-- Individual digit boxes --}}
    @for ($i = 0; $i < $length; $i++)
        <input
            type="{{ $inputType }}"
            inputmode="{{ $inputMode }}"
            maxlength="1"
            class="xushi-otp-box"
            style="{{ $boxStyle }}"
            :ref="'box{{ $i }}'"
            x-ref="box{{ $i }}"
            :value="digits[{{ $i }}]"
            @if($disabled) disabled @endif
            @if($autofocus && $i === 0) autofocus @endif
            autocomplete="one-time-code"
            spellcheck="false"
            data-index="{{ $i }}"
            @input="onInput($event, {{ $i }})"
            @keydown="onKeydown($event, {{ $i }})"
            @paste.prevent="onPaste($event)"
            @focus="onFocus($event, {{ $i }})"
            @click="$event.target.select()"
        >
        @if($i === ($length / 2) - 1 && $length % 2 === 0 && $length > 4)
            <span style="
                display: flex;
                align-items: center;
                color: var(--xushi-color-base-content);
                opacity: 0.25;
                font-size: 1.25rem;
                font-weight: 300;
                flex-shrink: 0;
                user-select: none;
            ">—</span>
        @endif
    @endfor
</div>
