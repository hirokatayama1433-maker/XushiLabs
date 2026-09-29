@props([
    'padding' => '0px 1rem',
    'radius' => '0px',
    'radiusbottom' => null,
    'gap' => '0px',
    'border' => null,
    'bordertop' => null,
    'borderbottom' => null,
    'borderleft' => null,
    'borderright' => null,
    'bordercolor' => 'var(--xushi-color-base-neutral)',
    'margin' => null,
    'margintop' => null,
    'marginbottom' => null,
    'marginleft' => null,
    'marginright' => null,
    'shadow' => 'var(--xushi-custom-layout-shadow)',
    'background' => 'var(--xushi-custom-header)',
    'width' => '100%',
    'height' => 'var(--header-h)',
])

@once
    <style>
        /* ── Header ── */
        .xushiheader {
            grid-area: header;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: var(--header-h);
            box-sizing: border-box;
            z-index: var(--xushi-z-shell-base);
        }
        /* ── Header slots ── */
        .xushi-header-left,
        .xushi-header-right {
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .xushi-header-center {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
        }

        .xushi-header-center-track {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .xushi-header-mobile-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: none;
            background: transparent;
            color: var(--xushi-color-base-content);
            cursor: pointer;
            padding: 0;
            flex-shrink: 0;
            border-radius: var(--xushi-radius-field);
            transition: background 150ms ease;
        }

        .xushi-header-mobile-toggle:hover {
            background: var(--xushi-color-base-200);
        }

        @media (max-width: 768px) {
            .xushiheader {
                flex-wrap: wrap;
                height: auto !important;
                min-height: var(--header-h);
                padding-top: 10px !important;
                padding-bottom: 0;
            }

            .xushi-header-mobile-toggle {
                display: inline-flex;
            }

            .xushi-header-left {
                flex: 1;
                min-width: 0;
                padding-left: 0.25rem;
            }

            .xushi-header-right {
                margin-left: 0;
            }

            .xushi-header-center {
                order: 3;
                width: 100%;
                flex: none;
                justify-content: flex-start;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
                border-top: 1px solid var(--xushi-color-base-border);
                padding-top: 0.375rem;
                padding-bottom: 0.375rem;
                margin-top: 0.25rem;
            }

            .xushi-header-center::-webkit-scrollbar {
                display: none;
            }

            .xushi-header-center-track {
                gap: 0.5rem;
                padding-right: 1rem;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
                justify-content: flex-start !important;
                width: 100%;
            }

            .xushi-header-center-track::-webkit-scrollbar {
                display: none;
            }

            .xushi-header-center {
                justify-content: flex-start !important;
            }

            .xushi-mobile-toggle {
                display: none !important;
            }
        }
       </style>
@endonce

<header
    class="xushiheader"
    style="
        display: flex;
        flex-direction: row;
        position: relative;
        z-index: var(--xushi-z-shell-base);
        border-style: solid;
        border-width: 0;
        background: {{ $background }};
        {{ $padding      ? 'padding: '             . $padding      . ';' : '' }}
        {{ $gap          ? 'gap: '                 . $gap          . ';' : '' }}
        {{ $radius       ? 'border-radius: '       . $radius       . ';' : '' }}
        {{ $radiusbottom ? 'border-bottom-left-radius: '  . $radiusbottom . ';' : '' }}
        {{ $radiusbottom ? 'border-bottom-right-radius: ' . $radiusbottom . ';' : '' }}
        {{ $shadow       ? 'box-shadow: '          . $shadow       . ';' : '' }}
        {{ $margin       ? 'margin: '              . $margin       . ';' : '' }}
        {{ $margintop    ? 'margin-top: '          . $margintop    . ';' : '' }}
        {{ $marginbottom ? 'margin-bottom: '       . $marginbottom . ';' : '' }}
        {{ $marginleft   ? 'margin-left: '         . $marginleft   . ';' : '' }}
        {{ $marginright  ? 'margin-right: '        . $marginright  . ';' : '' }}
        {{ $border       ? 'border-width: '        . $border       . ';' : '' }}
        {{ $bordertop    ? 'border-top-width: '    . $bordertop    . ';' : '' }}
        {{ $borderbottom ? 'border-bottom-width: ' . $borderbottom . ';' : '' }}
        {{ $borderleft   ? 'border-left-width: '   . $borderleft   . ';' : '' }}
        {{ $borderright  ? 'border-right-width: '  . $borderright  . ';' : '' }}
        {{ $bordercolor  ? 'border-color: '        . $bordercolor  . ';' : '' }}
        {{ $width        ? 'width: '               . $width        . ';' : '' }}
        {{ $height       ? 'height: '              . $height       . ';' : '' }}    
    "
    {{ $attributes }}
>
    {{-- Mobile sidebar toggle (far-left, visible only on mobile) --}}
    <button
        type="button"
        class="xushi-header-mobile-toggle"
        onclick="Xushi.Sidebar.toggleMobile()"
        aria-label="Toggle sidebar"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.25rem; height:1.25rem;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
        </svg>
    </button>

    @isset($left)
        <div class="xushi-header-left">{{ $left }}</div>
    @endisset

    <div class="xushi-header-center">
        <div class="xushi-header-center-track">
            {{ $slot }}
        </div>
    </div>

    @isset($right)
        <div class="xushi-header-right">{{ $right }}</div>
    @endisset
</header>