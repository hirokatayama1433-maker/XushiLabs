@props([
    'value'    => '',
    'open'     => false,
    'disabled' => false,
])

<div
    class="xushi-accordion-item"
    x-data="{ value: '{{ $value }}' }"
    :class="{ 'is-open': isOpen('{{ $value }}') }"
    style="border-top: 1px solid var(--xushi-color-base-border); {{ $disabled ? 'opacity:0.5; pointer-events:none;' : '' }}"
    x-bind:style="$el.parentElement.classList.contains('xushi-accordion--separated')
        ? 'border: 1px solid var(--xushi-color-base-border); border-radius: var(--xushi-radius-box); overflow:hidden;'
        : ''"
>
    {{-- Trigger --}}
    <button
        type="button"
        class="xushi-accordion-trigger"
        @click="
            toggle('{{ $value }}');
            const panel = $el.nextElementSibling;
            const inner = panel.firstElementChild;
            if (isOpen('{{ $value }}')) {
                panel.style.maxHeight = inner.scrollHeight + 'px';
                panel.style.opacity = '1';
            } else {
                panel.style.maxHeight = '0px';
                panel.style.opacity = '0';
            }
        "
        :aria-expanded="isOpen('{{ $value }}')"
        style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 1rem 1.25rem;
            background: transparent;
            border: none;
            cursor: {{ $disabled ? 'not-allowed' : 'pointer' }};
            font-family: inherit;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--xushi-color-base-content);
            text-align: left;
            gap: 1rem;
            transition: background 150ms ease;
            box-sizing: border-box;
        "
        onmouseover="this.style.background='var(--xushi-color-base-200)'"
        onmouseout="this.style.background='transparent'"
    >
        <span style="flex:1; min-width:0;">
            @isset($heading)
                {{ $heading }}
            @endisset
        </span>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="15px"
            height="15px"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            style="width:0.875rem; height:0.875rem; flex-shrink:0; transition:transform 250ms cubic-bezier(0.4,0,0.2,1); opacity:0.5;"
            :style="isOpen('{{ $value }}') ? 'transform:rotate(180deg)' : 'transform:rotate(0deg)'"
        >
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    {{-- Panel — JS height animation, no x-collapse plugin needed --}}
    <div
        class="xushi-accordion-panel"
        style="
            max-height: {{ $open ? '9999px' : '0px' }};
            opacity: {{ $open ? '1' : '0' }};
            overflow: hidden;
            transition: max-height 280ms cubic-bezier(0.4,0,0.2,1), opacity 200ms ease;
            border-top: {{ $open ? '1px solid var(--xushi-color-base-border)' : '0px solid transparent' }};
        "
    >
        <div style="padding: 1rem 1.25rem; font-size: 0.9rem; line-height: 1.6; color: var(--xushi-color-base-content);">
            {{ $slot }}
        </div>
    </div>
</div>
