@props([
    'variant'     => 'solid',
    'color'       => 'base',
    'padding'     => '1rem',
    'sections'    => 'flush',
    'radius'      => null,
    'shadow'      => null,
    'margin'      => null,
    'border'      => null,
    'bordercolor' => null,
    'title'       => null,
    'description' => null,
    'imgsrc'      => null,
    'imgalt'      => '',
    'imgheight'   => '200px',
    'footeralign' => 'end',
])

@once
<style>
    .xushi-card {
        overflow: hidden;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        width: fit-content;
        background: var(--xushi-card-bg);
        color: var(--xushi-card-color);
        border-radius: var(--xushi-card-radius, var(--xushi-radius-box));
        border: var(--xushi-card-border, none);
    }
    .xushi-card-img {
        width: 100%;
        display: block;
        object-fit: cover;
    }
    .xushi-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.5rem;
        padding: 1rem;
    }
    .xushi-card-header-text {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        flex: 1;
        min-width: 0;
    }
    .xushi-card-title {
        font-weight: 600;
        font-size: 1rem;
        color: var(--xushi-color-base-content);
    }
    .xushi-card-description {
        font-size: 0.8rem;
        color: var(--xushi-color-base-content-subtle);
    }
    .xushi-card-action {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        margin-left: auto;
        padding-left: 0.5rem;
    }
    .xushi-card-body {
        flex: 1;
    }
    .xushi-card-footer {
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── ruled ── */
    .xushi-card--ruled .xushi-card-header {
        border-bottom: 1px solid var(--xushi-color-base-neutral);
    }
    .xushi-card--ruled .xushi-card-footer {
        border-top: 1px solid var(--xushi-color-base-neutral);
    }

    /* ── banded ── */
    .xushi-card--banded .xushi-card-header {
        background: color-mix(in oklch, var(--xushi-color-base-content) 8%, var(--xushi-color-base-background));
    }
    .xushi-card--banded .xushi-card-footer {
        background: color-mix(in oklch, var(--xushi-color-base-content) 8%, var(--xushi-color-base-background));
    }
</style>
@endonce

@php
    $variants = [
        'solid' => [
            'base'      => ['background' => 'var(--xushi-color-base-foreground-plus)', 'color' => 'var(--xushi-color-base-content)'],
            'primary'   => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 8%, var(--xushi-color-base-foreground))',   'color' => 'var(--xushi-color-base-content)'],
            'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 8%, var(--xushi-color-base-foreground))', 'color' => 'var(--xushi-color-base-content)'],
            'danger'    => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 8%, var(--xushi-color-base-foreground))',    'color' => 'var(--xushi-color-base-content)'],
            'success'   => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 8%, var(--xushi-color-base-foreground))',   'color' => 'var(--xushi-color-base-content)'],
            'warning'   => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 8%, var(--xushi-color-base-foreground))',   'color' => 'var(--xushi-color-base-content)'],
            'info'      => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 8%, var(--xushi-color-base-foreground))',      'color' => 'var(--xushi-color-base-content)'],
        ],
        'soft' => [
            'base'      => ['background' => 'var(--xushi-color-base-neutral)',                                                          'color' => 'var(--xushi-color-base-content)'],
            'primary'   => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 12%, var(--xushi-color-base-foreground))',  'color' => 'var(--xushi-color-base-content)'],
            'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 12%, var(--xushi-color-base-foreground))','color' => 'var(--xushi-color-base-content)'],
            'danger'    => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 12%, var(--xushi-color-base-foreground))',   'color' => 'var(--xushi-color-base-content)'],
            'success'   => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 12%, var(--xushi-color-base-foreground))',  'color' => 'var(--xushi-color-base-content)'],
            'warning'   => ['background' => 'color-mix(in oklch, var(--xushi-color-warning) 12%, var(--xushi-color-base-foreground))',  'color' => 'var(--xushi-color-base-content)'],
            'info'      => ['background' => 'color-mix(in oklch, var(--xushi-color-info) 12%, var(--xushi-color-base-foreground))',     'color' => 'var(--xushi-color-base-content)'],
        ],
        'outline' => [
            'base'      => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-base-neutral)'],
            'primary'   => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-primary)'],
            'secondary' => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-secondary)'],
            'danger'    => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-danger)'],
            'success'   => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-success)'],
            'warning'   => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-warning)'],
            'info'      => ['background' => 'transparent', 'color' => 'var(--xushi-color-base-content)', 'border' => '1px solid var(--xushi-color-info)'],
        ],
    ];

    $resolved = $variants[$variant][$color]
        ?? $variants[$variant]['base']
        ?? $variants['solid']['base'];

    if ($bordercolor) $resolved['border'] = '1px solid ' . $bordercolor;
    if ($border)      $resolved['border'] = $border;

    $sectionClass = match($sections) {
        'ruled'  => 'xushi-card--ruled',
        'banded' => 'xushi-card--banded',
        default  => '',
    };

    $hasHeader = $title || $description || isset($action);

    // Put resolved values as CSS variables so external style="" cannot override them
    $cssVars = collect([
        '--xushi-card-bg'     => $resolved['background'],
        '--xushi-card-color'  => $resolved['color'],
        '--xushi-card-border' => $resolved['border'] ?? null,
        '--xushi-card-radius' => $radius ?? 'var(--xushi-radius-box)',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $extraStyle = collect([
        'box-shadow' => $shadow,
        'margin'     => $margin,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $style = trim($cssVars . '; ' . $extraStyle, '; ');
@endphp

<div {{ $attributes->merge(['class' => 'xushi-card ' . trim($sectionClass), 'style' => $style]) }}>

    {{-- Image zone --}}
    @if($imgsrc)
        <img
            class="xushi-card-img"
            src="{{ $imgsrc }}"
            alt="{{ $imgalt }}"
            style="height:{{ $imgheight }};"
        />
    @endif

    {{-- Title/description + action prop header --}}
    @if($hasHeader)
        <div class="xushi-card-header">
            <div class="xushi-card-header-text">
                @if($title)
                    <div class="xushi-card-title">{{ $title }}</div>
                @endif
                @if($description)
                    <div class="xushi-card-description">{{ $description }}</div>
                @endif
            </div>
            @isset($action)
                <div class="xushi-card-action">{{ $action }}</div>
            @endisset
        </div>
    @endif

    {{-- Raw header slot (fully custom) --}}
    @isset($header)
        <div class="xushi-card-header">{{ $header }}</div>
    @endisset

    {{-- Body --}}
    <div class="xushi-card-body" style="padding:{{ $padding }};">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @isset($footer)
        <div class="xushi-card-footer" style="justify-content: {{ $footeralign }};">
            {{ $footer }}
        </div>
    @endisset

</div>