@props([
    'href' => null,
    'src' => '',
    'name' => '',
    'alt' => '',
])

@php($tag = $href !== null ? 'a' : 'div')

@once
    <style>
        .xushi-sidebar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: inherit;
            text-decoration: none;
        }
    </style>
@endonce

<div style="display:flex; align-items:center; width:100%;">

    <{{ $tag }}
        @if($href) href="{{ $href }}" @endif
        style="display:flex; align-items:center; flex:1; min-width:0; text-decoration:none; color:inherit;"
        onclick="if (document.documentElement.classList.contains('sidebar-collapsed')) { event.preventDefault(); Xushi.Sidebar.expand(); }"
    >
        <div style="flex-shrink:0; width:38px; height:38px; display:flex; justify-content:center; align-items:center;">
            @if($src)
                <img src="{{ $src }}" alt="{{ $alt ?: $name }}" style="width:38px; height:38px; object-fit:contain;" />
            @else
                <div style="width:38px; height:38px; border-radius:var(--xushi-radius-field); display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; background:var(--xushi-color-accent); color:#fff; cursor:pointer;">
                    {{ strtoupper($name[0] ?? 'Z') }}
                </div>
            @endif
        </div>

        <span class="xushi-sb-text" style="padding-left:8px; font-size:14px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:inherit;">
            {{ $name }}
        </span>
    </{{ $tag }}>

</div>