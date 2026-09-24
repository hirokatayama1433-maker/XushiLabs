@props([
    'placeholder' => 'Search...',
    'name' => 'search',
    'value' => null,
    'kbd' => null,
    'icon' => 'search',
    'radius' => 'var(--xushi-radius-field)',
    'border' => 'var(--xushi-border-field)',
    'bordercolor' => 'var(--xushi-color-base-border)',
    'background' => 'var(--xushi-color-base-100)',
    'action' => null,
])

<div
    x-data="{ open: false }"
    class="xushi-header-search"
    style="position:relative; display:inline-flex; align-items:center;"
>
    <button
        type="button"
        @click="open = !open"
        aria-label="Search"
        style="
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: {{ $radius }};
            border: none;
            background: transparent;
            cursor: pointer;
            color: var(--xushi-color-base-content);
            opacity: 0.7;
            transition: opacity 150ms ease, background 150ms ease;
        "
        onmouseover="this.style.opacity='1'; this.style.background='var(--xushi-color-base-200)'"
        onmouseout="this.style.opacity='0.7'; this.style.background='transparent'"
    >
        <xushi:icon :name="$icon" size="1.125rem" />
    </button>

    <div
        x-show="open"
        x-cloak
        @click.outside="open = false"
        style="
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            z-index: var(--xushi-z-dropdown);
            min-width: 280px;
            background: var(--xushi-color-base-100);
            border-radius: var(--xushi-radius-box);
            box-shadow: var(--xushi-shadow);
            padding: 0.75rem;
            box-sizing: border-box;
        "
    >
        <form action="{{ $action ?? '#' }}" method="GET" role="search" style="display:flex; align-items:center; gap:0.5rem; margin:0;">
            <div style="
                flex: 1;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                height: 36px;
                padding: 0 0.75rem;
                border-radius: {{ $radius }};
                border: {{ $border }} solid {{ $bordercolor }};
                background: {{ $background }};
                color: var(--xushi-color-base-content);
                box-sizing: border-box;
            ">
                <xushi:icon :name="$icon" size="0.875rem" style="opacity:0.5; flex-shrink:0;" />
                <input
                    type="text"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    placeholder="{{ $placeholder }}"
                    style="
                        flex: 1;
                        background: transparent;
                        border: none;
                        outline: none;
                        color: inherit;
                        font: inherit;
                        font-size: 0.875rem;
                        min-width: 0;
                    "
                >
                @if($kbd)
                    <kbd style="font-size:0.65rem; padding:0.125rem 0.375rem; border-radius:var(--xushi-radius-selector); border:1px solid var(--xushi-color-base-border); opacity:0.5; flex-shrink:0;">{{ $kbd }}</kbd>
                @endif
            </div>
            <button
                type="submit"
                style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 36px;
                    height: 36px;
                    border-radius: {{ $radius }};
                    border: none;
                    background: var(--xushi-color-primary);
                    color: var(--xushi-color-primary-content);
                    cursor: pointer;
                    flex-shrink: 0;
                "
            >
                <xushi:icon :name="$icon" size="0.875rem" />
            </button>
        </form>
    </div>
</div>