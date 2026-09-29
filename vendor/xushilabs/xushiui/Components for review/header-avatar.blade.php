@props([
    'name' => '',
    'src' => '',
    'alt' => '',
    'href' => null,
    'caret' => true,
])

@php
    $tag = $href ? 'a' : 'button';
    $finalClasses = trim($attributes->get('class', ''));
@endphp

@once
    <style>
        .xushi-header-avatar{
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
    </style>
@endonce

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    {{ $attributes->except('class') }}
    @if($finalClasses !== '') class="{{ $finalClasses }}" @endif
    style="display:flex; align-items:center; gap:0.5rem; border:none; background:transparent; padding:0; cursor:pointer; color:inherit;"
>
    <div style="width:38px; height:38px; display:flex; justify-content:center; align-items:center; flex-shrink:0;">
        @if($src)
            <img
                src="{{ $src }}"
                alt="{{ $alt ?: $name }}"
                style="width:38px; height:38px; border-radius:var(--xushi-radius-field); object-fit:cover;"
            />
        @else
            <div style="width:38px; height:38px; border-radius:var(--xushi-radius-field); display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:600; background:var(--xushi-color-accent); color:var(--xushi-color-primary-content);">
                {{ collect(explode(' ', trim($name)))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join('') }}
            </div>
        @endif
    </div>

    @if($caret)
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor"
            style="width:1rem; height:1rem; opacity:0.5;"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    @endif

</{{ $tag }}>