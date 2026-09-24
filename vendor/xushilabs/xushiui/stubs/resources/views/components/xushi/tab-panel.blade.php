@props([
    'value' => '',
    'style' => null,
])

<div
    x-show="isActive('{{ $value }}')"
    x-cloak
    role="tabpanel"
    class="xushi-tab-panel {{ $attributes->get('class') }}"
    style="{{ $style }}{{ $attributes->get('style') }}"
    {{ $attributes->except(['class', 'style']) }}
>{{ $slot }}</div>
