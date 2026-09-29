@props([
    'mode' => 'collapsible',
    'collapse' => 'viewicons',
    'toggleLabel' => 'Collapse',
    'margin' => null,
    'marginleft' => null,
    'marginright' => null,
    'margintop' => null,
    'marginbottom' => null,
    'padding' => '6px',
    'radius' => null,
    'radiustop' => null,
    'radiusbottom' => null,
    'radiusleft' => null,
    'radiusright' => null,
    'border' => '0px',
    'bordertop' => null,
    'borderbottom' => null,
    'borderleft' => null,
    'borderright' => null,
    'gap' => null,
    'shadow' => 'var(--xushi-custom-layout-shadow)',
    'background' => 'var(--xushi-custom-sidebar)',
    'bordercolor' => 'var(--xushi-color-base-neutral)',
])

@once
    <style>
        /* ── Sidebar ── */
        .xushisidebar {
            grid-area: sidebar;
            display: flex;
            flex-direction: column;
            min-height: 0;
            overflow: visible;
            position: relative;
            z-index: var(--xushi-z-shell-elevated);
        }

        .xushisidebar aside {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            width: var(--sidebar-expanded-w);
            transition: none;
            overflow: visible;
        }

        html.sidebar-ready .xushisidebar aside {
            transition: width var(--layout-transition);
        }

        html.sidebar-collapsed .xushisidebar[data-collapse="viewicons"] aside {
            width: var(--sidebar-collapsed-w);
        }

        html.sidebar-collapsed .xushisidebar[data-collapse="full"] aside {
            width: 0;
            padding: 0 !important;
            border: none !important;
        }

        .xushi-sidebar-section {
            flex-shrink: 0;
        }

        .xushi-sidebar-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 0.25rem;
            min-height: 0;
            overflow-y: auto;
        }

        /* ── Collapse: hide text/labels ── */
        /* xushi-sb-text: any span that should vanish when collapsed */
        .xushi-sb-text {
            white-space: nowrap;
            overflow: hidden;
            transition: none;
        }

        html.sidebar-ready .xushi-sb-text {
            transition: opacity var(--layout-transition), max-width var(--layout-transition);
        }

        html.sidebar-collapsed .xushi-sb-text {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        /* sidebar-label: the section-group label text (MODULES, etc.) */
        .sidebar-label {
            white-space: nowrap;
            overflow: hidden;
            transition: none;
        }

        html.sidebar-ready .sidebar-label {
            transition: opacity var(--layout-transition), max-width var(--layout-transition);
        }

        html.sidebar-collapsed .sidebar-label {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        /* sidebar-divider: the line that appears in collapsed state */
        .sidebar-divider {
            display: none;
        }

        html.sidebar-collapsed .sidebar-divider {
            display: block;
            opacity: 1;
            max-height: 1px;
        }

        .xushi-mobile-backdrop {
            display: none;
        }

        @media (max-width: 768px) {
            html.sidebar-mobile-open,
            html.sidebar-mobile-open body {
                overflow: hidden;
            }

            .xushi-mobile-backdrop {
                position: fixed;
                inset: 0;
                z-index: 2;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                border: 0;
                padding: 0;
                appearance: none;
            }

            html.sidebar-mobile-open .xushi-mobile-backdrop {
                display: block;
            }

            .xushisidebar {
                grid-area: auto;
                position: fixed;
                inset: 0 auto 0 0;
                width: min(86vw, var(--sidebar-expanded-w)) !important;
                height: 100dvh;
                z-index: var(--xushi-z-drawer);
                flex: none !important;
                min-height: auto !important;
                overflow: visible !important;
                gap: 0 !important;
                border: 0 !important;
                box-shadow: 0px 0px !important;
                pointer-events: none;
            }

            .xushisidebar aside {
                width: 100%;
                height: 100%;
                transform: translateX(-100%);
                transition: transform 260ms var(--ease-out-smooth);
            }

            html.sidebar-mobile-open .xushisidebar {
                pointer-events: auto;
            }

            html.sidebar-mobile-open .xushisidebar aside,
            html.sidebar-mobile-open .xushisidebar[data-collapse="viewicons"] aside,
            html.sidebar-mobile-open .xushisidebar[data-collapse="full"] aside {
                width: min(86vw, var(--sidebar-expanded-w)) !important;
                padding: var(--xushi-sidebar-mobile-padding, 10px) !important;
            }

            html.sidebar-mobile-open .xushisidebar aside {
                transform: translateX(0);
            }

            /* restore all collapsible text on mobile when open */
            html.sidebar-mobile-open .xushi-sb-text,
            html.sidebar-mobile-open .sidebar-label {
                opacity: 1 !important;
                max-width: none !important;
                pointer-events: auto !important;
            }

            html.sidebar-mobile-open .sidebar-labelwrap {
                padding: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            html.sidebar-mobile-open .sidebar-divider {
                opacity: 0 !important;
                max-height: 0 !important;
            }

            html.sidebar-mobile-open .sidebar-toggle-icon-collapsed {
                opacity: 0 !important;
            }

            html.sidebar-mobile-open .sidebar-toggle-icon-expanded {
                opacity: 1 !important;
            }

            .xushi-mobile-toggle {
                display: flex;
                position: fixed;
                bottom: 1.5rem;
                left: 1.5rem;
                z-index: var(--xushi-z-mobile-toggle);
                width: 48px;
                height: 48px;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                border: none;
                padding: 0;
                appearance: none;
                cursor: pointer;
                box-shadow: var(--xushi-custom-layout-shadow);
                background: var(--xushi-color-primary);
                color: var(--xushi-color-primary-content);
            }

            html:not(.sidebar-mobile-open) .xushi-mobile-backdrop {
                display: none;
            }
        }

        /* ── Sidebar edge toggle ── */
        .xushi-sidebar-edge-toggle {
            position: absolute;
            right: -13px;
            top: 13px;
            width: 25px;
            height: 25px;
            border-radius: 25%;
            background: var(--xushi-color-base-foreground);
            border: 1px solid var(--xushi-color-base-neutral);
            color: var(--xushi-color-base-content);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: var(--xushi-shadow);
            transition: right var(--layout-transition), background 150ms ease;
            padding: 0;
            appearance: none;
        }

        .xushi-sidebar-edge-toggle:hover {
            background: var(--xushi-color-base-foreground);
            border-color: var(--xushi-color-base-neutral);
            color: var(--xushi-color-primary);
        }

        .xushi-sidebar-edge-toggle-icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            transition: transform var(--layout-transition);
        }

        html:not(.sidebar-collapsed) .xushi-sidebar-edge-toggle-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .xushi-sidebar-edge-toggle {
                display: none;
            }
        }
    </style>
@endonce

<div
    class="xushisidebar"
    data-mode="{{ $mode }}"
    data-collapse="{{ $collapse }}"
    style="flex: 1; min-height: 0; display: flex; flex-direction: column; gap: 8px; overflow: visible; border-style: solid;
        {{ $shadow       ? 'box-shadow: '          . $shadow       . ';' : '' }}
        {{ $radius       ? 'border-radius: '       . $radius       . ';' : '' }}
        {{ $radiustop    ? 'border-top-left-radius: '     . $radiustop    . '; border-top-right-radius: '    . $radiustop    . ';' : '' }}
        {{ $radiusbottom ? 'border-bottom-left-radius: '  . $radiusbottom . '; border-bottom-right-radius: ' . $radiusbottom . ';' : '' }}
        {{ $radiusleft   ? 'border-top-left-radius: '     . $radiusleft   . '; border-bottom-left-radius: '  . $radiusleft   . ';' : '' }}
        {{ $radiusright  ? 'border-top-right-radius: '    . $radiusright  . '; border-bottom-right-radius: ' . $radiusright  . ';' : '' }}
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
        {{ $bordercolor  ? 'border-color: '        . $bordercolor  . ';' : '' }}"
    onscroll="xushiSidebarScrollCheck(this)"
>
    <aside style="
        display: flex;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        overflow: hidden;
        position: relative;
        z-index: var(--xushi-z-shell-elevated);
        border-style: solid;
        border-width: 0;
        background: {{ $background }};
        padding: {{ $padding }};
        {{ $gap ? 'gap: ' . $gap . ';' : 'gap: 8px;' }}
        {{ $radius ? 'border-radius: ' . $radius . ';' : '' }}">

        @isset($header)
            <div style="
            flex-shrink: 0;
            {{ $gap ? 'gap: ' . $gap . ';' : 'gap: 8px;' }}">
            {{ $header }}
        </div>
        @endisset

        <div
            class="scrollbar-hide"
            style="flex: 1; min-height: 0; display: flex; flex-direction: column; gap: 8px; overflow-y: auto;"
            onscroll="xushiSidebarScrollCheck(this)"
        >
            {{ $slot }}
        </div>

        @isset($footer)
            <div style="
                flex-shrink: 0;
                gap: 8px;">
                {{ $footer }}
            </div>
        @endisset
    </aside>

    {{-- Mobile backdrop --}}
    <button
        type="button"
        class="xushi-mobile-backdrop"
        onclick="Xushi.Sidebar.closeMobile()"
        aria-label="Close sidebar"
    ></button>

    @if($mode === 'collapsible')
        <button
            type="button"
            class="xushi-sidebar-edge-toggle"
            onclick="Xushi.Sidebar.toggle()"
            aria-label="Toggle sidebar"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2.5"
                stroke="currentColor"
                class="xushi-sidebar-edge-toggle-icon"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    @endif
</div>
