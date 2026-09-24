@props([
    'variant'        => 'outline',
    'color'          => 'base',
    'size'           => 'md',
    'type'           => 'text',
    'value'          => null,
    'placeholder'    => null,
    'holderposition' => 'top',
    'disabled'       => false,
    'readonly'       => false,
    'invalid'        => false,
    'icon'           => null,
    'kbd'            => null,
    'clearable'      => false,
    'copyable'       => false,
    'viewable'       => false,
    'padding'        => null,
    'radius'         => 'var(--xushi-radius-field)',
    'shadow'         => null,
    'margin'         => null,
    'border'         => 'var(--xushi-border-field)',
    'bordercolor'    => null,
])

@php
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
            'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['base'];

    $sizePadding = [
        'sm' => '0 0.625rem',
        'md' => '0 0.875rem',
        'lg' => '0 1rem',
    ];

    if ($invalid) {
        $resolved['border-color'] = 'var(--xushi-color-danger)';
    }

    $style = collect(array_merge([
        'padding' => $padding ?? ($sizePadding[$size] ?? $sizePadding['md']),
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor ?? $resolved['border-color'],
        '--xushi-input-focus-border' => $invalid ? 'var(--xushi-color-danger)' : ($bordercolor ?? $resolved['border-color']),
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $iconTrailing = $attributes->get('icon:trailing');
    $hasLeadingIcon = $icon !== null || isset($iconslot);

    $trailingControl = match (true) {
        isset($trailing) || $iconTrailing !== null => 'custom',
        $viewable  => 'viewable',
        $copyable  => 'copyable',
        $clearable => 'clearable',
        default    => null,
    };

    $isPassword = $type === 'password';
    $isFloat    = $holderposition === 'float' && $placeholder !== null;

    $inputAttributes = $attributes->except(['class', 'icon', 'icon:trailing']);
@endphp

@once
    <style>
        .xushi-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-style: solid;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .xushi-input-wrapper:focus-within {
            border-color: var(--xushi-input-focus-border, var(--xushi-color-primary));
            box-shadow: 0 0 0 3px color-mix(in oklch, var(--xushi-input-focus-border, var(--xushi-color-primary)) 25%, transparent);
        }

        .xushi-input-wrapper.xushi-input--invalid {
            border-color: var(--xushi-color-danger);
        }

        .xushi-input-wrapper.xushi-input--invalid:focus-within {
            box-shadow: 0 0 0 3px color-mix(in oklch, var(--xushi-color-danger) 25%, transparent);
        }

        .xushi-input {
            flex: 1 1 auto;
            min-width: 0;
            border: none;
            outline: none;
            background: transparent;
            color: inherit;
            font: inherit;
            padding: 0;
            height: 100%;
        }

        /* ── Input icons & actions ── */
        .xushi-input-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            color: var(--xushi-color-base-content);
            opacity: 0.6;
        }

        .xushi-input-icon svg {
            width: 100%;
            height: 100%;
        }

        .xushi-input-kbd {
            flex-shrink: 0;
            font-size: 0.75rem;
            line-height: 1;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            border: 1px solid var(--xushi-color-base-border);
            color: var(--xushi-color-base-content);
            opacity: 0.6;
            font-family: inherit;
        }

        .xushi-input-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            color: var(--xushi-color-base-content);
            opacity: 0.6;
            transition: opacity 0.15s ease;
        }

        .xushi-input-action:hover { opacity: 1; }

        .xushi-input-action svg {
            width: 100%;
            height: 100%;
        }

        /* ── Affixes ── */
        .xushi-input-affix {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            height: 60%;
            font-size: 0.875rem;
            color: var(--xushi-color-base-content);
            opacity: 0.6;
            white-space: nowrap;
        }

        .xushi-input-affix--prefix {
            padding-right: 0.75rem;
            border-right: 1px solid var(--xushi-color-base-border);
        }

        .xushi-input-affix--suffix {
            padding-left: 0.75rem;
            border-left: 1px solid var(--xushi-color-base-border);
        }

        /* ── Float placeholder ── */
        .xushi-input--float {
            position: relative;
        }

        .xushi-input-float-placeholder {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: var(--xushi-color-base-content);
            opacity: 0.6;
            pointer-events: none;
            background: var(--xushi-color-base-100);
            padding: 0 0.25rem;
            transition: top 0.15s ease, font-size 0.15s ease, opacity 0.15s ease, color 0.15s ease;
        }

        .xushi-input--float .xushi-input:focus ~ .xushi-input-float-placeholder,
        .xushi-input--float .xushi-input:not(:placeholder-shown) ~ .xushi-input-float-placeholder {
            top: 0;
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .xushi-input--float:has(.xushi-input-icon--leading) .xushi-input-float-placeholder {
            left: 2rem;
        }

        /* ── Size variants ── */
        .xushi-input--xs { font-size: 0.75rem; }
        .xushi-input--xs .xushi-input,
        .xushi-input--xs input.xushi-input { height: 1.5rem; }

        .xushi-input--sm { font-size: 0.8125rem; }
        .xushi-input--sm .xushi-input,
        .xushi-input--sm input.xushi-input { height: 2rem; }

        .xushi-input--md .xushi-input,
        .xushi-input--md input.xushi-input { height: 2.5rem; }

        .xushi-input--lg { font-size: 1rem; }
        .xushi-input--lg .xushi-input,
        .xushi-input--lg input.xushi-input { height: 2.75rem; }
    </style>
@endonce

<div
    class="xushi-input-wrapper xushi-input--{{ $size }}{{ $invalid ? ' xushi-input--invalid' : '' }}{{ $isFloat ? ' xushi-input--float' : '' }}"
    style="{{ $style }}"
    @if($clearable) data-xushi-input-clearable @endif
    @if($copyable)  data-xushi-input-copyable  @endif
    @if($viewable)  data-xushi-input-viewable  @endif
>
    @isset($prefix)
        <div class="xushi-input-affix xushi-input-affix--prefix">{{ $prefix }}</div>
    @endisset

    {{-- Leading icon --}}
    @if($icon !== null)
        <span class="xushi-input-icon xushi-input-icon--leading">
            <xushi:icon name="{{ $icon }}" />
        </span>
    @elseif(isset($iconslot))
        <span class="xushi-input-icon xushi-input-icon--leading">{{ $iconslot }}</span>
    @endif

    <input
        class="xushi-input"
        type="{{ $isPassword && $viewable ? 'password' : $type }}"
        @disabled($disabled)
        @if($readonly) readonly @endif
        @if($value !== null) value="{{ $value }}" @endif
        @if($isFloat)
            placeholder=" "
        @elseif($placeholder !== null)
            placeholder="{{ $placeholder }}"
        @endif
        @if($invalid) aria-invalid="true" @endif
        data-xushi-input-field
        {{ $inputAttributes }}
    >

    {{-- Float placeholder label --}}
    @if($isFloat)
        <span class="xushi-input-float-placeholder">{{ $placeholder }}</span>
    @endif

    @if($kbd !== null)
        <kbd class="xushi-input-kbd">{{ $kbd }}</kbd>
    @endif

    @switch($trailingControl)
        @case('custom')
            <span class="xushi-input-icon xushi-input-icon--trailing">
                @if($iconTrailing !== null)
                    <xushi:icon name="{{ $iconTrailing }}" />
                @else
                    {{ $trailing }}
                @endif
            </span>
            @break

        @case('viewable')
            <button type="button" class="xushi-input-action" data-xushi-input-action="viewable" aria-label="Toggle password visibility">
                <xushi:icon name="eye" data-xushi-icon-show />
                <xushi:icon name="eye-off" data-xushi-icon-hide style="display:none" />
            </button>
            @break

        @case('copyable')
            <button type="button" class="xushi-input-action" data-xushi-input-action="copyable" aria-label="Copy to clipboard">
                <xushi:icon name="clipboard" data-xushi-icon-copy />
                <xushi:icon name="check" data-xushi-icon-copied style="display:none" />
            </button>
            @break

        @case('clearable')
            <button type="button" class="xushi-input-action" data-xushi-input-action="clearable" aria-label="Clear input">
                <xushi:icon name="x" />
            </button>
            @break
    @endswitch

    @isset($suffix)
        <div class="xushi-input-affix xushi-input-affix--suffix">{{ $suffix }}</div>
    @endisset
</div>