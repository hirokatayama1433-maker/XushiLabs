@props([
    'name' => '',
    'src' => '',
    'alt' => '',
    'href' => null,
])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->except('class') }}
    @if(trim($attributes->get('class', '')) !== '') class="{{ trim($attributes->get('class', '')) }}" @endif
    style="display:flex; align-items:center; gap:0.625rem; text-decoration:none; color:var(--xushi-color-base-content);"
>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt ?: $name }}" style="width:28px; height:28px; object-fit:contain; border-radius:var(--xushi-radius-field);" />
    @else
        <div style="width:28px; height:28px; border-radius:var(--xushi-radius-field); display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; background:var(--xushi-color-primary); color:var(--xushi-color-primary-content);">
            {{ strtoupper($name[0] ?? 'Z') }}
        </div>
    @endif

    @if($name)
        <span style="font-size:0.9rem; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0;">{{ $name }}</span>
    @endif

</{{ $tag }}>