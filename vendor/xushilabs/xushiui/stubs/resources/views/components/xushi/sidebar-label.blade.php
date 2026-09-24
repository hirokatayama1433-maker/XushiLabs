@props([
    'title' => '',
])

@once
    <style>
        /* ── Sidebar collapse: labels ── */
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
            .sidebar-divider {
                display: none;
            }

            html.sidebar-collapsed .sidebar-divider {
                display: block;
                opacity: 1;
                max-height: 1px;
            }

        </style>
@endonce

<div class="sidebar-labelwrap" style=" display:flex; align-items:center; width:100%; ">
    <span class="sidebar-label" style="font-size:0.625rem; font-weight:600; text-transform:uppercase; color:var(--xushi-custom-sidebar-content); opacity:0.5; white-space:nowrap;">
        {{ $title }}
    </span>
    <span class="sidebar-divider" style="width:50%; height:2px; background:color-mix(in srgb, var(--xushi-custom-sidebar-content) 40%, transparent); margin-left:5px;  border-radius: 20px; "></span>
</div>
