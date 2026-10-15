@props([
    'variant'     => 'outline',
    'color'       => 'base',
    'size'        => 'md',
    'name'        => null,
    'value'       => null,
    'placeholder' => 'Search...',
    'options'     => [],
    'disabled'    => false,
    'clearable'   => true,
    'freetext'    => false,
    'radius'      => 'var(--xushi-radius-field)',
    'shadow'      => null,
    'margin'      => null,
    'border'      => 'var(--xushi-border-field)',
    'bordercolor' => null,
    'emptytext'   => 'No results found',
])

@once
<style>
    .xushi-autocomplete { position: relative; width: 100%; }

    .xushi-autocomplete-panel {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    z-index: var(--xushi-z-dropdown);
    background: var(--xushi-color-base-foreground);
    border: 1px solid var(--xushi-color-base-border);
    border-radius: var(--xushi-radius-box);
    box-shadow: var(--xushi-shadow);
    max-height: 15rem;
    overflow-y: auto;
    box-sizing: border-box;
    padding: 0.25rem;
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

    .xushi-autocomplete-panel button {
        text-align: left;
        padding-left: 1rem;
        justify-content: flex-start;
        }

    .xushi-autocomplete-panel button span {
        flex: 1;
        text-align: left;
        
    }
</style>
@endonce

@once
<script>
    (function () {
        if (window._xushiAutocompleteRegistered) return;
        window._xushiAutocompleteRegistered = true;

        document.addEventListener('alpine:init', () => {
            try {
                Alpine.data('xushiAutocomplete', ({ options = [], selected = null, freetext = false, emptytext = 'No results found' } = {}) => ({
                    options,
                    selected,
                    query: '',
                    open: false,
                    highlighted: -1,
                    freetext,
                    emptytext,

                    init() {
                        if (this.selected !== null) {
                            const opt = this.options.find(o => o.value === this.selected);
                            this.query = opt ? opt.label : this.selected;
                        }
                    },

                    get filtered() {
                        const q = this.query.toLowerCase();
                        if (!q) return this.options;
                        return this.options.filter(o =>
                            o.label.toLowerCase().includes(q) || o.value.toLowerCase().includes(q)
                        );
                    },

                    onInput(val) {
                        this.query       = val;
                        this.open        = true;
                        this.highlighted = -1;
                        if (this.freetext) {
                            this.selected = val || null;
                        } else if (val === '') {
                            this.selected = null;
                        }
                    },

                    selectOption(opt) {
                        this.selected    = opt.value;
                        this.query       = opt.label;
                        this.open        = false;
                        this.highlighted = -1;
                        this.$el.dispatchEvent(new CustomEvent('xushi:autocomplete-change', {
                            detail: { value: opt.value, label: opt.label },
                            bubbles: true,
                        }));
                    },

                    selectHighlighted() {
                        if (this.highlighted >= 0 && this.filtered[this.highlighted]) {
                            this.selectOption(this.filtered[this.highlighted]);
                        } else if (this.freetext && this.query) {
                            this.selected = this.query;
                            this.open     = false;
                        } else {
                            this.open = false;
                        }
                    },

                    moveHighlight(dir) {
                        this.open = true;
                        const len = this.filtered.length;
                        if (len === 0) return;
                        this.highlighted = (this.highlighted + dir + len) % len;
                        this.$nextTick(() => {
                            const el = this.$refs.panel?.querySelectorAll('button')[this.highlighted];
                            el?.scrollIntoView({ block: 'nearest' });
                        });
                    },

                    clear() {
                        this.query       = '';
                        this.selected    = null;
                        this.open        = false;
                        this.$refs.input?.focus();
                        this.$el.dispatchEvent(new CustomEvent('xushi:autocomplete-change', {
                            detail: { value: null },
                            bubbles: true,
                        }));
                    },
                }));
            } catch (e) {
                console.error('[Xushi] xushiAutocomplete failed to register', e);
            }
        });
    })();
</script>
@endonce

@php
    $variantStyles = [
        'outline' => [
            'base'    => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
            'success' => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-success)'],
            'danger'  => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-danger)'],
        ],
        'soft' => [
            'base'    => ['background' => 'var(--xushi-color-base-neutral)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
            'primary' => ['background' => 'color-mix(in oklch, var(--xushi-color-primary) 10%, var(--xushi-color-base-foreground))', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'transparent'],
        ],
    ];

    $resolved = $variantStyles[$variant][$color]
        ?? $variantStyles[$variant]['base']
        ?? $variantStyles['outline']['base'];

    $style = collect(array_merge($resolved, [
        'border-radius' => $radius,
        'box-shadow'    => $shadow,
        'margin'        => $margin,
        'border-width'  => $border,
        'border-color'  => $bordercolor ?? $resolved['border-color'],
        'opacity'       => $disabled ? '0.5' : null,
    ]))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');

    $optionsJson = json_encode(
        collect($options)->map(function ($opt) {
            if (is_string($opt)) return ['label' => $opt, 'value' => $opt];
            return [
                'label' => $opt['label'] ?? $opt['value'] ?? '',
                'value' => $opt['value'] ?? $opt['label'] ?? '',
            ];
        })->values()->all()
    );

    $sizes = [
        'sm' => ['height' => '2rem',   'padding' => '0 0.625rem', 'font' => '0.8125rem'],
        'md' => ['height' => '2.5rem', 'padding' => '0 0.875rem', 'font' => '0.875rem'],
        'lg' => ['height' => '3rem',   'padding' => '0 1rem',     'font' => '1rem'],
    ];
    $sz = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    x-data="xushiAutocomplete({
        options: {{ $optionsJson }},
        selected: {{ $value ? json_encode($value) : 'null' }},
        freetext: {{ $freetext ? 'true' : 'false' }},
        emptytext: {{ json_encode($emptytext) }}
    })"
    class="xushi-autocomplete"
    @click.outside="open = false"
    {{ $attributes->except(['class', 'style']) }}
>
    {{-- Attributes pass through to the native element: wire:model, x-model, :disabled, @input, @change, @blur, name, id --}}

    @if($name)
        <input type="hidden" name="{{ $name }}" :value="selected ?? ''">
    @endif

    {{-- Trigger --}}
    <div
        style="
            {{ $style }};
            height: {{ $sz['height'] }};
            padding: {{ $sz['padding'] }};
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-style: solid;
            cursor: text;
            box-sizing: border-box;
        "
    >
        <span style="flex-shrink:0; display:flex; opacity:0.45;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:0.9375rem;height:0.9375rem;">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </span>

        <input
            x-ref="input"
            type="text"
            style="flex:1; min-width:0; border:none; outline:none; background:transparent; font-size:{{ $sz['font'] }}; font-family:inherit; color:inherit; height:100%; padding:0;"
            placeholder="{{ $placeholder }}"
            :value="query"
            @if($disabled) disabled @endif
            @input="onInput($event.target.value)"
            @focus="open = true"
            @keydown.arrow-down.prevent="moveHighlight(1)"
            @keydown.arrow-up.prevent="moveHighlight(-1)"
            @keydown.enter.prevent="selectHighlighted()"
            @keydown.escape="open = false"
            @keydown.tab="selectHighlighted()"
        >

        @if($clearable)
            <button
                type="button"
                x-show="selected !== null || query !== ''"
                x-cloak
                @click.stop="clear()"
                style="flex-shrink:0; display:flex; align-items:center; justify-content:center; width:1.125rem; height:1.125rem; border:none; background:transparent; cursor:pointer; padding:0; color:inherit; opacity:0.5; transition:opacity 120ms;"
                onmouseover="this.style.opacity='1'"
                onmouseout="this.style.opacity='0.5'"
                aria-label="Clear"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:0.75rem;height:0.75rem;">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        @endif

        <span style="flex-shrink:0; display:flex; opacity:0.45; transition:transform 200ms ease;" :style="open ? 'transform:rotate(180deg)' : ''">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </span>
    </div>

    {{-- Dropdown panel --}}
    <div
        x-show="open"
        x-cloak
        x-ref="panel"
        class="xushi-autocomplete-panel"
        style="display:none;"
    >
        <div
            x-show="filtered.length === 0"
            style="padding:0.75rem 0.875rem; font-size:0.875rem; color:var(--xushi-color-base-content); opacity:0.5; text-align:center;"
            x-text="emptytext"
        ></div>

        <template x-for="(opt, i) in filtered" :key="opt.value">
            <button
                type="button"
                @click="selectOption(opt)"
                @mouseenter="highlighted = i"
                style="display:flex; align-items:center; justify-content:space-between; width:100%; padding:0.5rem 0.75rem; border:none; background:transparent; text-align:left; font-size:0.875rem; font-family:inherit; border-radius:calc(var(--xushi-radius-field) - 2px); cursor:pointer; color:var(--xushi-color-base-content); transition:background 100ms ease;"
                :style="highlighted === i ? 'background:var(--xushi-color-base-neutral);' : ''"
            >
                <span x-text="opt.label"></span>
                <svg
                    x-show="selected === opt.value"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    style="width:0.875rem;height:0.875rem;color:var(--xushi-color-primary);flex-shrink:0;"
                >
                    <path d="m5 13 4 4 10-10"/>
                </svg>
            </button>
        </template>
    </div>
</div>