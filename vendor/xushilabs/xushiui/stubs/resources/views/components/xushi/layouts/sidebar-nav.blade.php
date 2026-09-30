@props([
    'label' => null,
])

@if($label)
    @once
        <style>
            .sidebar-labelwrap .sidebar-nav-divider {
                display: block;
                width: 0 !important;
                max-width: 0;
                max-height: 2px;
                margin-left: 0;
                margin-right: 0;
                opacity: 0;
                overflow: hidden;
                transition: width var(--layout-transition), max-width var(--layout-transition), margin var(--layout-transition), opacity var(--layout-transition);
            }

            html.sidebar-collapsed .sidebar-labelwrap .sidebar-nav-divider {
                width: 20px !important;
                max-width: 30px;
                margin-left: auto;
                margin-right: auto;
                opacity: 1;
            }
        </style>
    @endonce

    {{--
        Label header:
        - Expanded: shows text label (uppercase, small, dimmed) + a short trailing line
        - Collapsed: text vanishes (xushi-sb-text), the divider line spans full width
    --}}
    <div
        class="sidebar-labelwrap"
        style="display:flex; align-items:center; justify-content:start; width:100%; margin-top:0.25rem; min-width:0;"
    >
        <span
            class="xushi-sb-text"
            style="font-size:0.625rem; font-weight:600; text-transform:uppercase; color:var(--xushi-color-base-content); opacity:0.5; white-space:nowrap; flex-shrink:0;"
        >{{ $label }}</span>

        {{-- Collapsed: full-width separator that replaces the label --}}
        <span
            class="sidebar-nav-divider"
            style="width:20px; height:2px; background:color-mix(in srgb, var(--xushi-color-base-content) 25%, transparent); margin-left:auto; margin-right:auto; border-radius:20px;"
        ></span>
    </div>
@endif

<div
    {{ $attributes->except('class') }}
    style="display:flex; flex-direction:column; gap:4px;"
>
    {{ $slot }}
</div>