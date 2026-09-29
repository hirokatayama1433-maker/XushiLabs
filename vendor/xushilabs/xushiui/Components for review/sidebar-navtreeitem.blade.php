@props([
    'href' => '',
    'active' => false,
    'background' => null,
    'color' => null,
    'radius' => null,
])

@once
<script>
    window.xushiTooltip ??= function xushiTooltip() {
        return {
            open: false,
            init() {
                window.addEventListener('xushi:sidebar-toggled', () => {
                    this.open = false;
                });
            },
            show(trigger, panel) {
                this.open = true;
                this.$nextTick(() => xushiPosition(trigger, panel));
            },
            hide() {
                this.open = false;
            },
        };
    };

    document.addEventListener('alpine:init', () => {
        if (typeof Alpine === 'undefined') return;
        Alpine.data('xushiTooltip', window.xushiTooltip);
    });
</script>
@endonce

@php
    $bg = $background ?? ($active ? 'var(--xushi-color-base-foreground)' : 'transparent');
    $fg = $color ?? ($active ? 'var(--xushi-color-primary)' : 'var(--xushi-color-sidebar-content)');
    $rad = $radius ?? 'var(--xushi-radius-field)';
    $baseStyle = "
        display: block;
        width: 100%;
        font-size: 14px;
        padding: 0.375rem 0.5rem;
        border-radius: {$rad};
        transition: background 150ms ease, color 150ms ease;
        cursor: pointer;
        border: none;
        box-sizing: border-box;
        font-family: inherit;
        text-decoration: none;
        text-align: left;
        background: {$bg};
        color: {$fg};
    ";
    $hoverBg = $background ?? 'var(--xushi-color-base-foreground)';
    $hoverColor = $color ?? 'var(--xushi-color-primary)';
@endphp

@php($tag = $href !== '' ? 'a' : 'button')
@once
    <style>
            .navtree-items {
                position: relative;
                overflow: hidden;
                opacity: 0;
                transition: max-height 300ms cubic-bezier(0.4, 0, 0.2, 1), opacity 150ms ease;
            }

            .xushinavtree.navtree-open .navtree-items {
                opacity: 1;
            }
            
      </style>
@endonce
<{{ $tag }}
    @if($href !== '') href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    onclick="Xushi.Sidebar.closeMobile()"
    {{ $attributes->except('class') }}
    style="{{ $baseStyle }}"
    @if(!$active)
        onmouseover="this.style.background='{{ $hoverBg }}'; this.style.color='{{ $hoverColor }}';"
        onmouseout="this.style.background='{{ $background ?? 'transparent' }}'; this.style.color='{{ $color ?? 'var(--xushi-custom-sidebar-content)' }}';"
    @endif
>{{ $slot }}</{{ $tag }}>
