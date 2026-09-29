@props([
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => null,
    'disabled' => false,
    'style' => null,
])

<input
    class="xushi-range"
    style="{{ $style }}"
    type="range"
    min="{{ $min }}"
    max="{{ $max }}"
    step="{{ $step }}"
    value="{{ $value }}"
    @disabled($disabled)
    {{ $attributes }}
>
