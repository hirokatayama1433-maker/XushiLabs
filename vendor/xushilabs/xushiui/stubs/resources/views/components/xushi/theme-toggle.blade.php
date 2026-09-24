@props([
    'color' => 'neutral',
    'mode' => 'system',
    'accent' => null,
])

@php
    $themeColors = [
        'neutral' => '#737373',
        'red'     => '#ef4444',
        'orange'  => '#f97316',
        'yellow'  => '#eab308',
        'lime'    => '#84cc16',
        'green'   => '#16a34a',
        'teal'    => '#14b8a6',
        'cyan'    => '#06b6d4',
        'sky'     => '#0ea5e9',
        'blue'    => '#3b82f6',
        'violet'  => '#8b5cf6',
        'purple'  => '#a855f7',
        'magenta' => '#d946ef',
        'pink'    => '#ec4899',
    ];

    $themeNames = [];

    foreach ($themeColors as $color => $accent) {
        foreach (['light', 'dark'] as $mode) {
            foreach (['minimalist', 'maximalist'] as $style) {
                $themeNames[] = [
                    'name'   => "xushitheme-{$color}-{$mode}-{$style}",
                    'color'  => $color,
                    'mode'   => $mode,
                    'style'  => $style,
                    'accent' => $accent,
                ];
            }
        }
    }
@endphp

@once
    <style>
        /* ── Theme Picker ── */

        .xushi-theme-picker {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 2px;
        }

        .xushi-theme-picker-item {
            display: flex;
            align-items: center;
            width: 100%;
            min-height: 30px;
            padding: 0.25rem 0.5rem;
            gap: 0.625rem;

            border: 1px solid transparent;
            border-radius: var(--xushi-radius-field);

            background: transparent;
            color: var(--xushi-color-base-content);

            font-size: 0.75rem;
            font-weight: 400;
            line-height: 1;

            text-align: left;
            cursor: pointer;
            appearance: none;

            transition:
                background 120ms ease,
                border-color 120ms ease,
                color 120ms ease;
        }

        .xushi-theme-picker-item:hover {
            background: var(--xushi-color-base-200);
        }

        .xushi-theme-picker-item.is-active {
            background: var(--xushi-color-base-200);
            border-color: var(--xushi-color-base-border);
        }

        .xushi-theme-picker-swatch {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 18px;
            height: 18px;
            flex-shrink: 0;

            border: 1px solid var(--xushi-color-base-border);
            border-radius: 5px;

            overflow: hidden;
            background: var(--xushi-color-base-100);
        }

        .xushi-theme-picker-swatch-accent {
            width: 7px;
            height: 7px;
            border-radius: 2px;
        }

        .xushi-theme-picker-swatch-dark {
            background: #171717;
        }

        .xushi-theme-picker-swatch-light {
            background: #fafafa;
        }

        .xushi-theme-picker-label {
            flex: 1;
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .xushi-theme-picker-style {
            flex-shrink: 0;

            font-size: 0.6rem;
            opacity: 0.45;
        }
    </style>
@endonce

<div
    class="xushi-theme-picker"
    role="listbox"
    aria-label="Theme"
>
    @foreach ($themeNames as $theme)
        <button
            type="button"
            class="xushi-theme-picker-item"
            data-xushi-theme="{{ $theme['name'] }}"
            role="option"
            aria-selected="false"
            onclick="Xushi.Theme.set('{{ $theme['name'] }}')"
        >
            <span
                class="xushi-theme-picker-swatch xushi-theme-picker-swatch-{{ $theme['mode'] }}"
                aria-hidden="true"
            >
                <span
                    class="xushi-theme-picker-swatch-accent"
                    style="background: {{ $theme['accent'] }};"
                ></span>
            </span>

            <span class="xushi-theme-picker-label">
                {{ ucfirst($theme['color']) }}
                {{ ucfirst($theme['mode']) }}
            </span>

            <span class="xushi-theme-picker-style">
                {{ ucfirst($theme['style']) }}
            </span>
        </button>
    @endforeach
</div>

@once
<script>
    (() => {
        function syncXushiThemePicker() {
            const current = localStorage.getItem('xushi-theme');

            document
                .querySelectorAll('[data-xushi-theme]')
                .forEach(button => {
                    const active = button.dataset.xushiTheme === current;

                    button.classList.toggle('is-active', active);
                    button.setAttribute('aria-selected', active ? 'true' : 'false');
                });
        }

        document.addEventListener('xushi-theme-changed', syncXushiThemePicker);

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', syncXushiThemePicker);
        } else {
            syncXushiThemePicker();
        }
    })();
</script>
@endonce
