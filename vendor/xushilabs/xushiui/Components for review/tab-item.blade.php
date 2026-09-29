@props([
    'value' => '',
    'icon' => null,
    'disabled' => false,
])

<button
    type="button"
    role="tab"
    class="xushi-tab-item {{ $attributes->get('class') }}"
    :class="isActive('{{ $value }}') ? 'is-active' : ''"
    :aria-selected="isActive('{{ $value }}')"
    @disabled($disabled)
    @click="setActive('{{ $value }}')"
    {{ $attributes->except(['class', 'icon']) }}
>@if($icon)<xushi:icon :name="$icon" />@endif{{ $slot }}</button>
