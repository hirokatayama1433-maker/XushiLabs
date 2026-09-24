@props([
    'variant' => 'body',
    'as' => 'auto',
    'style' => null,
])

@php
    $resolvedTag = match(true) {
        $as !== 'auto'     => $as,
        $variant === 'code'    => 'code',
        $variant === 'caption' => 'span',
        $variant === 'strong'  => 'strong',
        default                => 'p',
    };
@endphp
@once
<style>
    .xushi-text {
        color: var(--xushi-color-base-content);
        line-height: 1.6;
    }

    .xushi-text--code {
        font-family: ui-monospace, monospace;
        font-size: 0.875em;
        background: var(--xushi-color-base-200);
        padding: 0.125rem 0.375rem;
        border-radius: var(--xushi-radius-selector);
    }
</style>
@endonce

<{{ $resolvedTag }} class="xushi-text xushi-text--{{ $variant }}" style="{{ $style }}" {{ $attributes }}>{{ $slot }}</{{ $resolvedTag }}>
