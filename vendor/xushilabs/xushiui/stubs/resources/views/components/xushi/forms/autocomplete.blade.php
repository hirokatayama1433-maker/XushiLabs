@props([
    'variant' => 'outline',
    'color' => 'base',
    'size' => 'md',
    'name' => null,
    'value' => null,
    'placeholder' => 'Search...',
    'options' => [],
    'disabled' => false,
    'clearable' => true,
    'freetext' => false,
    'radius' => 'var(--xushi-radius-field)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-field)',
    'bordercolor' => null,
    'emptytext' => 'No results found',
])

@php
    $variantStyles = [
        'outline' => [
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
            'success' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-success)'],
            'danger' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-danger)'],
        ],
        'soft' => [
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['base'];

    $style = collect(array_merge([
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor ?? $resolved['border-color'],
        '--xushi-input-focus-border' => $bordercolor ?? $resolved['border-color'],
        'opacity' => $disabled ? '0.5' : null,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $optionsJson = json_encode(collect($options)->map(function($opt) {
        if (is_string($opt)) return ['label' => $opt, 'value' => $opt];
        return ['label' => $opt['label'] ?? $opt['value'] ?? '', 'value' => $opt['value'] ?? $opt['label'] ?? ''];
    })->values()->all());

    $sizePadding = ['sm' => '0 0.625rem', 'md' => '0 0.875rem', 'lg' => '0 1rem'][$size] ?? '0 0.875rem';
    $sizeHeight  = ['sm' => '2rem', 'md' => '2.5rem', 'lg' => '3rem'][$size] ?? '2.5rem';
@endphp

<div
    x-data="xushiAutocomplete({
        options: {{ $optionsJson }},
        selected: {{ $value ? json_encode($value) : 'null' }},
        freetext: {{ $freetext ? 'true' : 'false' }},
        emptytext: {{ json_encode($emptytext) }}
    })"
    class="xushi-autocomplete"
    style="position: relative; width: 100%;"
    {{ $attributes->except(['class', 'style']) }}
>
    {{-- Hidden value for form submission --}}
    @if($name)
        <input type="hidden" name="{{ $name }}" :value="selected ?? ''">
    @endif

    {{-- Input wrapper --}}
    <div
        class="xushi-input-wrapper"
        style="
            {{ $style }};
            height: {{ $sizeHeight }};
            padding: {{ $sizePadding }};
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-style: solid;
            cursor: text;
            box-sizing: border-box;
        "
        :class="open ? 'xushi-autocomplete--open' : ''"
    >
        {{-- Search icon --}}
        <span style="flex-shrink:0; display:flex; opacity:0.45; color:inherit;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                stroke-linecap="round" stroke-linejoin="round"
                style="width:0.9375rem; height:0.9375rem;">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </span>

        <input
            x-ref="input"
            type="text"
            style="
                flex: 1;
                min-width: 0;
                border: none;
                outline: none;
                background: transparent;
                font-size: {{ ['sm' => '0.8125rem', 'md' => '0.875rem', 'lg' => '1rem'][$size] ?? '0.875rem' }};
                font-family: inherit;
                color: inherit;
                height: 100%;
                padding: 0;
            "
            placeholder="{{ $placeholder }}"
            :value="query"
            @if($disabled) disabled @endif
            @input="onInput($event.target.value)"
            @focus="onFocus()"
            @keydown.arrow-down.prevent="moveHighlight(1)"
            @keydown.arrow-up.prevent="moveHighlight(-1)"
            @keydown.enter.prevent="selectHighlighted()"
            @keydown.escape="close()"
            @keydown.tab="selectHighlighted()"
        >

        {{-- Clear button --}}
        @if($clearable)
            <button
                type="button"
                x-show="selected !== null || query !== ''"
                x-cloak
                @click.stop="clear()"
                style="
                    flex-shrink: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 1.125rem;
                    height: 1.125rem;
                    border: none;
                    background: transparent;
                    cursor: pointer;
                    padding: 0;
                    color: inherit;
                    opacity: 0.5;
                    transition: opacity 120ms;
                "
                onmouseover="this.style.opacity='1'"
                onmouseout="this.style.opacity='0.5'"
                aria-label="Clear"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:0.75rem; height:0.75rem;">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        @endif

        {{-- Chevron --}}
        <span
            style="flex-shrink:0; display:flex; opacity:0.45; transition:transform 200ms ease;"
            :style="open ? 'transform:rotate(180deg)' : 'transform:rotate(0deg)'"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                style="width:0.875rem; height:0.875rem;">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </span>
    </div>

    {{-- Dropdown panel --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-ref="panel"
            @click.outside="close()"
            x-bind:class="open ? 'xushi-dropdown-enter' : 'xushi-dropdown-leave'"
            style="
                position: fixed;
                z-index: var(--xushi-z-dropdown);
                background: var(--xushi-color-base-100);
                border: 1px solid var(--xushi-color-base-border);
                border-radius: var(--xushi-radius-box);
                box-shadow: var(--xushi-shadow);
                max-height: 15rem;
                overflow-y: auto;
                box-sizing: border-box;
                padding: 0.25rem;
            "
        >
            {{-- Empty state --}}
            <div
                x-show="filtered.length === 0"
                style="
                    padding: 0.75rem 0.875rem;
                    font-size: 0.875rem;
                    color: var(--xushi-color-base-content-muted);
                    text-align: center;
                "
                x-text="emptytext"
            ></div>

            {{-- Options --}}
            <template x-for="(opt, i) in filtered" :key="opt.value">
                <button
                    type="button"
                    @click="selectOption(opt)"
                    @mouseenter="highlighted = i"
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        width: 100%;
                        padding: 0.5rem 0.75rem;
                        border: none;
                        background: transparent;
                        text-align: left;
                        font-size: 0.875rem;
                        font-family: inherit;
                        border-radius: calc(var(--xushi-radius-field) - 2px);
                        cursor: pointer;
                        color: var(--xushi-color-base-content);
                        transition: background 100ms ease;
                    "
                    :style="highlighted === i ? 'background: var(--xushi-color-base-200);' : ''"
                    :class="selected === opt.value ? 'xushi-autocomplete-active' : ''"
                >
                    <span x-text="opt.label"></span>

                    {{-- Check for selected --}}
                    <svg
                        x-show="selected === opt.value"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="width:0.875rem; height:0.875rem; color:var(--xushi-color-primary); flex-shrink:0;"
                    >
                        <path d="m5 13 4 4 10-10"/>
                    </svg>
                </button>
            </template>
        </div>
    </template>
</div>
