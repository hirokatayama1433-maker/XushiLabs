@props([
    'href' => null,
    'active' => false,
])

@php
    $tag = $href ? 'a' : 'button';
    $finalClasses = trim($attributes->get('class', ''));
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    {{ $attributes->except('class') }}
    @if($finalClasses !== '') class="{{ $finalClasses }}" @endif
    style="position:relative; display:flex; align-items:center; gap:0.5rem; padding:0 0.75rem; height:38px; cursor:pointer; transition:color 150ms ease; {{ $active ? 'color:var(--xushi-color-primary-content); font-weight:600; opacity:1;' : 'color:var(--xushi-color-primary-content); opacity:0.6;' }}"
>
    @isset($iconslot)
        <span style="flex-shrink:0;">{{ $iconslot }}</span>
    @endisset

    <span>{{ $slot }}</span>

    @isset($badge)
        {{ $badge }}
    @endisset

    @isset($trailing)
        <span style="flex-shrink:0; opacity:0.5;">{{ $trailing }}</span>
    @endisset

    @if($active)
        <span
            style="position:absolute; bottom:0; left:50%; transform:translateX(-50%); width:20px; height:2px; border-radius:9999px; background-color:var(--xushi-color-primary-content);"
            aria-hidden="true"
        ></span>
    @endif

</{{ $tag }}>           