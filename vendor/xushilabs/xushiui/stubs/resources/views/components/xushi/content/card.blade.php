@props([
    'variant' => 'solid',
    'color' => 'base',
    'padding' => '1.25rem',
    'radius' => 'var(--xushi-radius-box)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-box)',
    'bordercolor' => 'var(--xushi-color-base-border)',
    'title' => null,
    'description' => null,
    'imgsrc' => null,
    'imgalt' => null,
    'imgheight' => '200px',
    'closable' => false,
    'size' => 'full',
    'width' => null,
    'wide' => false,
    'tall' => false,
    'full' => false,
    'colspan' => 2,
    'rowspan' => 2,
])

@php
    $variantStyles = [
        'solid' => [
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 8%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)'],
            'dark' => ['background' => 'var(--xushi-color-base-900)', 'color' => 'var(--xushi-color-base-100)'],
        ],
        'soft' => [
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 12%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)'],
            'dark' => ['background' => 'var(--xushi-color-base-800)', 'color' => 'var(--xushi-color-base-100)'],
        ],
        'outline' => [
            'base' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-border)'],
            'primary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-primary)'],
            'dark' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-900)'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color] ?? $variantStyles[$variant]['base'] ?? $variantStyles['solid']['base'];

    $sizeMap = [
        'sm' => '20rem',
        'md' => '28rem',
        'lg' => '36rem',
        'xl' => '48rem',
        'full' => '100%',
    ];

    $gridColumn = match (true) {
        $full => '1 / -1',
        $wide => 'span ' . $colspan,
        default => null,
    };

    $gridRow = $tall ? 'span ' . $rowspan : null;
    $isGridPlaced = $full || $wide || $tall;

    $hasImg = !empty($imgsrc);
    $hasTitle = !empty($title);
    $hasDesc = !empty($description);
    $hasHeader = $hasTitle || $hasDesc || isset($header);
    $innerPadding = $padding ?? '1.25rem';

    $style = collect(array_merge([
        'padding' => $hasImg ? '0' : $padding,
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
        'width' => ($size || $isGridPlaced) ? '100%' : $width,
        'max-width' => ($size && ! $isGridPlaced) ? ($sizeMap[$size] ?? null) : null,
        'grid-column' => $gridColumn,
        'grid-row' => $gridRow,
        'align-self' => $isGridPlaced ? 'stretch' : null,
        'height' => $isGridPlaced ? 'auto' : null,
    ], $resolved))->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-card {
        background: var(--xushi-color-base);
        border-radius: var(--xushi-radius-box);
        border: var(--xushi-border-box) solid var(--xushi-color-base-border);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        
    }

     .xushi-card--tall {
        height: 100%;
        align-self: stretch;
    }
    /* ── Image zone ─────────────────────────────────── */
    .xushi-card-img {
        width: 100%;
        display: block;
        object-fit: cover;
        flex-shrink: 0;
    }

    /* ── Inner padding wrapper (used when imgsrc present) ── */
    .xushi-card-inner {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: var(--xushi-card-inner-padding, 1.25rem);
    }

    /* ── Header: title + description + optional close ── */
    .xushi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .xushi-card-header-text {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .xushi-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        line-height: 1.3;
        color: inherit;
        margin: 0;
    }

    .xushi-card-description {
        font-size: 0.8125rem;
        color: color-mix(in oklch, currentColor 60%, transparent);
        margin: 0;
        line-height: 1.4;
    }

    .xushi-card-close {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        border: none;
        background: transparent;
        color: inherit;
        cursor: pointer;
        border-radius: var(--xushi-radius-sm);
        opacity: 0.6;
        transition: opacity 150ms;
        font-size: 1rem;
        padding: 0;
    }

    .xushi-card-close:hover { opacity: 1; }

    /* ── Body ───────────────────────────────────────── */
    .xushi-card-body {
        flex: 1;
    }

    /* ── Footer ─────────────────────────────────────── */
    .xushi-card-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: var(--xushi-border-box) solid color-mix(in oklch, currentColor 10%, transparent);
    }

    /* ── No padding mode: body/footer get their own padding ── */
    .xushi-card--has-img > .xushi-card-inner > .xushi-card-body { }
    .xushi-card--has-img > .xushi-card-inner > .xushi-card-footer {
        padding-top: 0.75rem;
    }
</style>
@endonce

<div
    class="xushi-card {{ $hasImg ? 'xushi-card--has-img' : '' }} {{ ($tall ?? false) ? 'xushi-card--tall' : '' }}"
    style="{{ $style }}{{ $hasImg ? '; --xushi-card-inner-padding:' . $innerPadding . ';' : '' }}"
    {{ $attributes }}
>
    {{-- Image zone --}}
    @if($hasImg)
        <img
            class="xushi-card-img"
            src="{{ $imgsrc }}"
            alt="{{ $imgalt ?? $title ?? '' }}"
            style="height: {{ $imgheight }};"
        >
    @endif

    {{-- Inner wrapper (provides padding when image is present) --}}
    <div class="{{ $hasImg ? 'xushi-card-inner' : '' }}" style="{{ $hasImg ? '' : 'display:contents;' }}">

        {{-- Header: structured title/description OR legacy $header slot --}}
        @if($hasHeader)
            <div class="xushi-card-header">
                <div class="xushi-card-header-text">
                    @if($hasTitle)
                        <p class="xushi-card-title">{{ $title }}</p>
                    @endif
                    @if($hasDesc)
                        <p class="xushi-card-description">{{ $description }}</p>
                    @endif
                    @if(isset($header))
                        {{ $header }}
                    @endif
                </div>

                @if($closable)
                    <button class="xushi-card-close" type="button" aria-label="Close">
                        <xushi:icon name="x" />
                    </button>
                @endif
            </div>
        @endif

        {{-- Body --}}
        <div class="xushi-card-body">{{ $slot }}</div>

        {{-- Footer --}}
        @isset($footer)
            <div class="xushi-card-footer">{{ $footer }}</div>
        @endisset

    </div>
</div>