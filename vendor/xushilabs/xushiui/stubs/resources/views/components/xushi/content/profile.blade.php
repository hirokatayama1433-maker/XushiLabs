@props([
    'name' => '',
    'role' => null,
    'email' => null,
    'src' => null,
    'alt' => '',
    'href' => null,
    'layout' => 'horizontal',
    'avatarSize' => 'md',
    'margin' => null,
    'background' => null,
    'padding' => null,
    'radius' => null,
])

@php
    $tag = $href ? 'a' : 'div';

    $avatarSizes = [
        'sm' => '2rem',
        'md' => '2.5rem',
        'lg' => '3rem',
        'xl' => '4rem',
    ];

    $sz = $avatarSizes[$avatarSize] ?? $avatarSizes['md'];

    $avatarStyle = collect([
        'width' => $sz,
        'height' => $sz,
        'border-radius' => '999px',
        'object-fit' => 'cover',
        'flex-shrink' => '0',
        'display' => 'flex',
        'align-items' => 'center',
        'justify-content' => 'center',
        'font-size' => 'calc(' . $sz . ' * 0.38)',
        'font-weight' => '600',
        'background' => 'var(--xushi-color-accent)',
        'color' => '#fff',
        'overflow' => 'hidden',
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $style = collect([
        'display' => 'flex',
        'align-items' => $layout === 'vertical' ? 'center' : 'center',
        'flex-direction' => $layout === 'vertical' ? 'column' : 'row',
        'gap' => $layout === 'compact' ? '0.5rem' : '0.75rem',
        'margin' => $margin,
        'background' => $background,
        'padding' => $padding,
        'border-radius' => $radius,
        'text-decoration' => 'none',
        'color' => 'inherit',
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-profile {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
</style>
@endonce

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    class="xushi-profile xushi-profile--{{ $layout }}"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{-- Avatar --}}
    <div style="{{ $avatarStyle }}">
        @if($src)
            <img src="{{ $src }}" alt="{{ $alt ?: $name }}" style="width:100%;height:100%;object-fit:cover;" />
        @else
            {{ collect(explode(' ', trim($name)))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join('') }}
        @endif
    </div>

    {{-- Info --}}
    <div style="
        display:flex;
        flex-direction:column;
        min-width:0;
        {{ $layout === 'vertical' ? 'align-items:center; text-align:center;' : '' }}
        {{ $layout === 'compact' ? 'gap:0;' : 'gap:0.125rem;' }}
    ">
        <span style="font-size:{{ $layout === 'compact' ? '0.875rem' : '0.9375rem' }}; font-weight:600; line-height:1.3; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:var(--xushi-color-base-content);">
            {{ $name }}
        </span>

        @if($role)
            <span style="font-size:0.8125rem; line-height:1.3; color:var(--xushi-color-base-content-muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                {{ $role }}
            </span>
        @endif

        @if($email && $layout !== 'compact')
            <span style="font-size:0.75rem; line-height:1.3; color:var(--xushi-color-base-content-muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                {{ $email }}
            </span>
        @endif

        @isset($meta)
            <div style="margin-top:0.25rem;">{{ $meta }}</div>
        @endisset
    </div>

    @isset($trailing)
        <div style="margin-left:auto; flex-shrink:0;">{{ $trailing }}</div>
    @endisset

</{{ $tag }}>
