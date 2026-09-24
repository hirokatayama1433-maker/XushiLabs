@props([
    'multiple' => false,
    'variant'  => 'default',
    'default'  => null,
    'radius'   => null,
    'margin'   => null,
])

@php
    $style = collect([
        'display'        => 'flex',
        'flex-direction' => 'column',
        'width'          => '100%',
        'border-radius'  => $radius ?? 'var(--xushi-radius-box)',
        'margin'         => $margin,
        'overflow'       => $variant === 'default' ? 'hidden' : null,
        'border'         => $variant === 'default' ? '1px solid var(--xushi-color-base-border)' : null,
        'gap'            => $variant === 'separated' ? '0.5rem' : null,
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

{{-- accordion.blade.php — XushiUI Accordion Component --}}

@once
<style>
    /* ── Accordion ── */
    .xushi-accordion-item:first-child {
        border-top: none !important;
    }

    .xushi-accordion--separated > .xushi-accordion-item {
        border: 1px solid var(--xushi-color-base-border) !important;
        border-radius: var(--xushi-radius-box) !important;
        overflow: hidden !important;
    }

    .xushi-accordion--separated .xushi-accordion-item {
        border-top: none !important;
    }

    .xushi-accordion-trigger:focus-visible {
        outline: 2px solid var(--xushi-color-primary);
        outline-offset: -2px;
    }

    /* ── Accordion panel — CSS-driven open/close ── */
    .xushi-accordion-panel {
        display: grid;
        grid-template-rows: 0fr;
        opacity: 0;
        transition:
            grid-template-rows 280ms cubic-bezier(0.4, 0, 0.2, 1),
            opacity 200ms ease,
            border-top 200ms ease;
        border-top: 0px solid transparent;
    }

    .xushi-accordion-panel > * {
        overflow: hidden;
    }

    .xushi-accordion-panel.is-open {
        grid-template-rows: 1fr;
        opacity: 1;
        border-top: 1px solid var(--xushi-color-base-border);
    }
</style>
@endonce

@once
<script>
    /* ── Accordion ── */
    function xushiAccordion({ multiple = false, default: defaultOpen = '' } = {}) {
        return {
            openItems: defaultOpen ? [defaultOpen] : [],

            toggle(value) {
                if (this.isOpen(value)) {
                    this.openItems = this.openItems.filter(v => v !== value);
                } else {
                    this.openItems = multiple
                        ? [...this.openItems, value]
                        : [value];
                }
            },

            isOpen(value) {
                return this.openItems.includes(value);
            },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiAccordion', xushiAccordion);
    });
</script>
@endonce

@php
    // ── Accordion — resolve variant class and pass Alpine config
@endphp

<div
    x-data="xushiAccordion({ multiple: {{ $multiple ? 'true' : 'false' }}, default: '{{ $default ?? '' }}' })"
    class="xushi-accordion xushi-accordion--{{ $variant }}"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>