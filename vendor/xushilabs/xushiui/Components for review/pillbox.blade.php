@props([
    'variant' => 'outline',
    'color' => 'base',
    'size' => 'md',
    'name' => null,
    'placeholder' => 'Add tag...',
    'value' => [],
    'max' => null,
    'disabled' => false,
    'radius' => 'var(--xushi-radius-field)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-field)',
    'bordercolor' => null,
    'tagcolor' => 'primary',
    'tagvariant' => 'soft',
])

@php
    $variantStyles = [
        'outline' => [
            'base' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
        ],
        'soft' => [
            'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-100))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color] ?? $variantStyles[$variant]['base'] ?? $variantStyles['outline']['base'];

    $style = collect(array_merge([
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor ?? $resolved['border-color'],
        'opacity' => $disabled ? '0.5' : null,
        'cursor' => $disabled ? 'not-allowed' : null,
    ], $resolved))->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');

    $tagColors = [
        'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 18%, transparent)', 'color' => 'var(--xushi-color-primary)'],
        'secondary' => ['background' => 'color-mix(in oklch, var(--xushi-color-secondary) 18%, transparent)', 'color' => 'var(--xushi-color-secondary)'],
        'danger' => ['background' => 'color-mix(in oklch, var(--xushi-color-danger) 18%, transparent)', 'color' => 'var(--xushi-color-danger)'],
        'success' => ['background' => 'color-mix(in oklch, var(--xushi-color-success) 18%, transparent)', 'color' => 'var(--xushi-color-success)'],
        'base' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
    ];
    $resolvedTag = $tagColors[$tagcolor] ?? $tagColors['primary'];
    $tagBg = $resolvedTag['background'];
    $tagColor = $resolvedTag['color'];

    $sizePadding = ['sm' => '0 0.625rem', 'md' => '0 0.75rem', 'lg' => '0 0.875rem'][$size] ?? '0 0.75rem';
    $sizeHeight = ['sm' => '2rem', 'md' => '2.5rem', 'lg' => '3rem'][$size] ?? '2.5rem';
    $initialTags = is_array($value) ? json_encode($value) : '[]';
@endphp

<div
    x-data="xushiPillbox({
        tags: {{ $initialTags }},
        max: {{ $max ?? 'null' }},
        disabled: {{ $disabled ? 'true' : 'false' }}
    })"
    class="xushi-pillbox xushi-pillbox--{{ $size }}"
    style="
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.375rem;
        min-height: {{ $sizeHeight }};
        padding: 0.375rem {{ $sizePadding }};
        border-style: solid;
        cursor: text;
        box-sizing: border-box;
        {{ $style }}
    "
    @click="$refs.input.focus()"
>
    {{-- Hidden input for form submission --}}
    <template x-for="(tag, i) in tags" :key="i">
        <input type="hidden" name="{{ $name }}[]" :value="tag">
    </template>

    {{-- Rendered pills --}}
    <template x-for="(tag, i) in tags" :key="tag">
        <span
            class="xushi-pillbox-tag"
            style="
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
                padding: 0 0.5rem;
                height: 1.625rem;
                border-radius: calc(var(--xushi-radius-field) - 2px);
                font-size: 0.8125rem;
                font-weight: 500;
                white-space: nowrap;
                flex-shrink: 0;
                background: {{ $tagBg }};
                color: {{ $tagColor }};
            "
        >
            <span x-text="tag"></span>
            @if(!$disabled)
                <button
                    type="button"
                    @click.stop="removeTag(i)"
                    style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 1rem;
                        height: 1rem;
                        border: none;
                        background: transparent;
                        cursor: pointer;
                        padding: 0;
                        color: currentColor;
                        opacity: 0.6;
                        border-radius: 999px;
                        flex-shrink: 0;
                        transition: opacity 120ms ease, background 120ms ease;
                    "
                    onmouseover="this.style.opacity='1'; this.style.background='rgba(0,0,0,0.12)';"
                    onmouseout="this.style.opacity='0.6'; this.style.background='transparent';"
                    :aria-label="`Remove ${tag}`"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round"
                        style="width:0.625rem; height:0.625rem;">
                        <path d="m6 6 12 12M18 6 6 18"/>
                    </svg>
                </button>
            @endif
        </span>
    </template>

    {{-- Input --}}
    <input
        x-ref="input"
        type="text"
        placeholder="{{ $placeholder }}"
        :placeholder="tags.length > 0 ? '' : '{{ $placeholder }}'"
        class="xushi-pillbox-input"
        style="
            border: none;
            outline: none;
            background: transparent;
            font-size: {{ ['sm' => '0.8125rem', 'md' => '0.875rem', 'lg' => '1rem'][$size] ?? '0.875rem' }};
            font-family: inherit;
            color: inherit;
            min-width: 8rem;
            flex: 1;
            height: 1.75rem;
            padding: 0;
        "
        @if($disabled) disabled @endif
        @keydown.enter.prevent="addTagFromInput($event.target)"
        @keydown.tab="$event.target.value.trim() !== '' && (addTagFromInput($event.target), $event.preventDefault())"
        @keydown.backspace="$event.target.value === '' && removeTag(tags.length - 1)"
        @keydown.comma.prevent="addTagFromInput($event.target)"
        @paste.prevent="handlePaste($event)"
        {{ $attributes->only(['id', 'autocomplete']) }}
    >
</div>
