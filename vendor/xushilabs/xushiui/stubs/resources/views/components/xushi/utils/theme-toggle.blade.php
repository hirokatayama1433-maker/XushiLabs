@props([
    'show' => ['mode', 'accent', 'palette', 'layout'],
])

@once
    <style>
        /* ── Theme Picker ── */

        .xushi-theme-picker {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
        }

        .xushi-theme-picker-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .xushi-theme-picker-title {
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--xushi-color-base-content-subtle);
        }

        .xushi-theme-picker-options {
            display: grid;
            gap: 2px;
        }

        .xushi-theme-picker-options-segmented {
            grid-auto-flow: column;
            grid-auto-columns: 1fr;
        }

        .xushi-theme-picker-options-palette {
            grid-template-columns: repeat(2, 1fr);
        }

        .xushi-theme-picker-options-accent {
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            padding: 4px;
        }

        .xushi-theme-picker-item {
            display: flex;
            align-items: center;
            min-width: 0;
            min-height: 30px;
            padding: 0.25rem 0.5rem;
            gap: 0.5rem;

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

        .xushi-theme-picker-item-center {
            justify-content: center;
        }

        .xushi-theme-picker-item:hover {
            background: var(--xushi-color-base-neutral);
        }

        .xushi-theme-picker-item.is-active {
            background: var(--xushi-color-base-neutral);
            border-color: var(--xushi-color-base-border);
            font-weight: 600;
        }

        .xushi-theme-picker-item:focus-visible,
        .xushi-theme-picker-accent:focus-visible {
            outline: 2px solid var(--xushi-color-primary);
            outline-offset: 2px;
        }

        .xushi-theme-picker-label {
            flex: 1;
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Palette swatch: light half + dark half */
        .xushi-theme-picker-swatch {
            width: 18px;
            height: 18px;
            flex-shrink: 0;

            border: 1px solid var(--xushi-color-base-border);
            border-radius: 5px;

            background: linear-gradient(135deg, var(--sw-l) 50%, var(--sw-d) 50%);
        }

        /* Layout preview: corner radius of that layout */
        .xushi-theme-picker-shape {
            width: 14px;
            height: 14px;
            flex-shrink: 0;

            border: 2px solid currentColor;
            border-radius: var(--r);
            opacity: 0.6;
        }

        /* Accent dot */
        .xushi-theme-picker-accent {
            width: 100%;
            aspect-ratio: 1;

            border: 0;
            border-radius: 999px;
            padding: 0;

            background: var(--sw);
            cursor: pointer;
            appearance: none;

            transition: box-shadow 120ms ease, transform 120ms ease;
        }

        .xushi-theme-picker-accent:hover {
            transform: scale(1.12);
        }

        .xushi-theme-picker-accent.is-active {
            box-shadow:
                0 0 0 2px var(--xushi-color-base-foreground),
                0 0 0 4px var(--sw);
        }
    </style>
@endonce

@php
    $pickerModes    = \Xushi\UI\XushiThemeRegistry::modes();
    $pickerAccents  = \Xushi\UI\XushiThemeRegistry::accents();
    $pickerPalettes = \Xushi\UI\XushiThemeRegistry::palettes();
    $pickerLayouts  = \Xushi\UI\XushiThemeRegistry::layouts();
@endphp

<div
    {{ $attributes->merge(['class' => 'xushi-theme-picker']) }}
    x-data="{ t: {} }"
    x-init="t = window.Xushi?.Theme?.parts() || {}"
    @xushi-theme-changed.document="t = window.Xushi?.Theme?.parts() || {}"
>
    @if (in_array('mode', $show, true))
        <div class="xushi-theme-picker-group">
            <span class="xushi-theme-picker-title">Mode</span>
            <div class="xushi-theme-picker-options xushi-theme-picker-options-segmented" role="radiogroup" aria-label="Mode">
                @foreach ($pickerModes as $pickerMode)
                    <button
                        type="button"
                        role="radio"
                        class="xushi-theme-picker-item xushi-theme-picker-item-center"
                        :class="t.mode === '{{ $pickerMode }}' ? 'is-active' : ''"
                        :aria-checked="t.mode === '{{ $pickerMode }}'"
                        @click="Xushi.Theme.setMode('{{ $pickerMode }}')"
                    >{{ ucfirst($pickerMode) }}</button>
                @endforeach
            </div>
        </div>
    @endif

    @if (in_array('accent', $show, true))
        <div class="xushi-theme-picker-group">
            <span class="xushi-theme-picker-title">Accent</span>
            <div class="xushi-theme-picker-options xushi-theme-picker-options-accent" role="radiogroup" aria-label="Accent">
                @foreach ($pickerAccents as $pickerAccent)
                    <button
                        type="button"
                        role="radio"
                        title="{{ ucfirst($pickerAccent) }}"
                        aria-label="{{ ucfirst($pickerAccent) }}"
                        class="xushi-theme-picker-accent"
                        style="--sw: {{ \Xushi\UI\XushiThemes::$accents[$pickerAccent]['--xushi-color-primary'] }};"
                        :class="t.accent === '{{ $pickerAccent }}' ? 'is-active' : ''"
                        :aria-checked="t.accent === '{{ $pickerAccent }}'"
                        @click="Xushi.Theme.setAccent('{{ $pickerAccent }}')"
                    ></button>
                @endforeach
            </div>
        </div>
    @endif

    @if (in_array('palette', $show, true))
        <div class="xushi-theme-picker-group">
            <span class="xushi-theme-picker-title">Palette</span>
            <div class="xushi-theme-picker-options xushi-theme-picker-options-palette" role="radiogroup" aria-label="Palette">
                @foreach ($pickerPalettes as $pickerPalette)
                    <button
                        type="button"
                        role="radio"
                        class="xushi-theme-picker-item"
                        :class="t.palette === '{{ $pickerPalette }}' ? 'is-active' : ''"
                        :aria-checked="t.palette === '{{ $pickerPalette }}'"
                        @click="Xushi.Theme.setPalette('{{ $pickerPalette }}')"
                    >
                        <span
                            class="xushi-theme-picker-swatch"
                            style="--sw-l: {{ \Xushi\UI\XushiThemes::$bases[$pickerPalette . '-light']['--xushi-color-base-background'] }}; --sw-d: {{ \Xushi\UI\XushiThemes::$bases[$pickerPalette . '-dark']['--xushi-color-base-background'] }};"
                            aria-hidden="true"
                        ></span>
                        <span class="xushi-theme-picker-label">{{ ucfirst($pickerPalette) }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    @if (in_array('layout', $show, true))
        <div class="xushi-theme-picker-group">
            <span class="xushi-theme-picker-title">Layout</span>
            <div class="xushi-theme-picker-options xushi-theme-picker-options-segmented" role="radiogroup" aria-label="Layout">
                @foreach ($pickerLayouts as $pickerLayout)
                    <button
                        type="button"
                        role="radio"
                        class="xushi-theme-picker-item xushi-theme-picker-item-center"
                        :class="t.layout === '{{ $pickerLayout }}' ? 'is-active' : ''"
                        :aria-checked="t.layout === '{{ $pickerLayout }}'"
                        @click="Xushi.Theme.setLayout('{{ $pickerLayout }}')"
                    >
                        <span
                            class="xushi-theme-picker-shape"
                            style="--r: {{ \Xushi\UI\XushiThemes::$layouts[$pickerLayout]['--xushi-control-radius'] }};"
                            aria-hidden="true"
                        ></span>
                        {{ ucfirst($pickerLayout) }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>
