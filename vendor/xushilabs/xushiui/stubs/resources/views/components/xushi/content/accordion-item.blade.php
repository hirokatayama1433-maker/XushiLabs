{{-- accordion-item --}}
@props([
    'value'    => '',
    'open'     => false,
    'disabled' => false,
])

<div
    class="xushi-accordion-item"
    style="border-top: 1px solid var(--xushi-color-base-border); {{ $disabled ? 'opacity:0.5; pointer-events:none;' : '' }}"
>
    {{-- Trigger --}}
    <button
        type="button"
        class="xushi-accordion-trigger"
        @click="toggle('{{ $value }}')"
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
            @isset($heading){{ $heading }}@endisset
        </span>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            style="width:0.875rem; height:0.875rem; flex-shrink:0; opacity:0.5; transition:transform 250ms cubic-bezier(0.4,0,0.2,1);"
            :style="isOpen('{{ $value }}') ? 'transform:rotate(180deg); width:0.875rem; height:0.875rem; opacity:0.5;' : 'transform:rotate(0deg); width:0.875rem; height:0.875rem; opacity:0.5;'"
        >
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

        {{-- Panel --}}
    <div
        class="xushi-accordion-panel {{ $open ? 'is-open' : '' }}"
        :class="{ 'is-open': isOpen('{{ $value }}') }"
    >
        <div style="overflow:hidden;">
            <div style="padding: 1rem 1.25rem; font-size: 0.9rem; line-height: 1.6; color: var(--xushi-color-base-content); background: var(--xushi-color-base-foreground-plus);">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>