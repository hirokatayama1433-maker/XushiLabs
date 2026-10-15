@props([
    'name'        => null,
    'value'       => null,
    'placeholder' => 'Pick a time',
    'seconds'     => false,
    'meridiem'    => false,
    'step'        => 1,
    'disabled'    => false,
    'clearable'   => true,
    'variant'     => 'outline',
    'color'       => 'base',
    'radius'      => 'var(--xushi-radius-field)',
    'shadow'      => null,
    'margin'      => null,
    'border'      => 'var(--xushi-border-field)',
    'bordercolor' => null,
])

@once
<style>
    .xushi-time-picker { position: relative; width: 100%; }

    .xushi-time-picker-panel {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        z-index: var(--xushi-z-dropdown);
        background: var(--xushi-color-base-foreground);
        border-radius: var(--xushi-radius-box);
        box-shadow: var(--xushi-shadow);
        border: 1px solid var(--xushi-color-base-border);
        box-sizing: border-box;
        min-width: fit-content;
    }

    .xushi-time-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 1.75rem;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: var(--xushi-radius-selector);
        color: var(--xushi-color-base-content);
        opacity: 0.5;
        transition: opacity 120ms, background 120ms;
    }

    .xushi-time-arrow:hover {
        opacity: 1;
        background: var(--xushi-color-base-neutral);
    }
</style>
@endonce

@once
<script>
    (function () {
        if (window._xushiTimePickerRegistered) return;
        window._xushiTimePickerRegistered = true;

        function xushiTimePicker({ value = null, showSeconds = false, meridiem = false, step = 1 } = {}) {
            const parse = (v) => {
                if (!v) return [meridiem ? 12 : 0, 0, 0, 'AM'];
                const parts = v.split(':').map(Number);
                let h = parts[0] ?? 0, m = parts[1] ?? 0, s = parts[2] ?? 0;
                let period = 'AM';
                if (meridiem) {
                    period = h >= 12 ? 'PM' : 'AM';
                    h = h % 12 || 12;
                }
                return [h, m, s, period];
            };

            const [initH, initM, initS, initPeriod] = parse(value);

            return {
                open: false,
                hours: initH,
                minutes: initM,
                seconds: initS,
                period: initPeriod,
                showSeconds,
                meridiem,
                step,

                toggle() { this.open = !this.open; },
                close()  { this.open = false; },

                pad(n) { return String(n).padStart(2, '0'); },

                step(field, amount) {
                    if (field === 'hours') {
                        const max = this.meridiem ? 12 : 23;
                        const min = this.meridiem ? 1  : 0;
                        this.hours = ((this.hours - min + amount + (max - min + 1)) % (max - min + 1)) + min;
                    } else if (field === 'minutes') {
                        this.minutes = ((this.minutes + amount) + 60) % 60;
                    } else if (field === 'seconds') {
                        this.seconds = ((this.seconds + amount) + 60) % 60;
                    }
                },

                getValue() {
                    let h = this.hours;
                    if (this.meridiem) {
                        if (this.period === 'PM' && h !== 12) h += 12;
                        if (this.period === 'AM' && h === 12) h = 0;
                    }
                    let out = `${this.pad(h)}:${this.pad(this.minutes)}`;
                    if (this.showSeconds) out += `:${this.pad(this.seconds)}`;
                    return out;
                },

                clear() {
                    this.hours   = this.meridiem ? 12 : 0;
                    this.minutes = 0;
                    this.seconds = 0;
                    this.period  = 'AM';
                },
            };
        }

        document.addEventListener('alpine:init', () => {
            try { Alpine.data('xushiTimePicker', xushiTimePicker); }
            catch (e) { console.error('[Xushi] xushiTimePicker failed to register', e); }
        });
    })();

    function xushiAnchorPanel(trigger, panel) {
    if (!trigger || !panel) return;
    const tr  = trigger.getBoundingClientRect();
    const gap = 6;

    panel.style.position = 'fixed';
    panel.style.top      = '-9999px';
    panel.style.left     = '-9999px';
    panel.style.display  = 'block';

    const pr = panel.getBoundingClientRect();
    const vw = window.innerWidth;
    const vh = window.innerHeight;

    // Vertical: prefer below, flip above if no room
    let top = tr.bottom + gap;
    if (top + pr.height > vh - gap) top = tr.top - pr.height - gap;
    if (top < gap) top = gap;

    // Horizontal: align to trigger left, push left if overflows
    let left = tr.left;
    if (left + pr.width > vw - gap) left = vw - pr.width - gap;
    if (left < gap) left = gap;

    panel.style.top  = top  + 'px';
    panel.style.left = left + 'px';
}
</script>
@endonce

@php
    $variantStyles = [
        'outline' => [
            'base'    => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-base-border)'],
            'primary' => ['background' => 'var(--xushi-color-base-foreground)', 'color' => 'var(--xushi-color-base-content)', 'border-color' => 'var(--xushi-color-primary)'],
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

    $triggerStyle = collect(array_merge($resolved, [
        'border-radius' => $radius,
        'box-shadow'    => $shadow,
        'margin'        => $margin,
        'border-width'  => $border,
        'border-color'  => $bordercolor ?? $resolved['border-color'],
        'opacity'       => $disabled ? '0.5' : null,
    ]))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    x-data="xushiTimePicker({
        value: {{ $value ? json_encode($value) : 'null' }},
        showSeconds: {{ $seconds ? 'true' : 'false' }},
        meridiem: {{ $meridiem ? 'true' : 'false' }},
        step: {{ $step }}
    })"
    class="xushi-time-picker"
    @click.outside="close()"
    {{ $attributes->except(['class', 'style']) }}
>
    @if($name)
        <input type="hidden" name="{{ $name }}" :value="getValue()">
    @endif

    {{-- Trigger --}}
    <div
        style="{{ $triggerStyle }}; height:var(--xushi-size-field); padding:0 0.875rem; display:flex; align-items:center; gap:0.5rem; border-style:solid; cursor:pointer; box-sizing:border-box;"
        @click="@if(!$disabled) toggle() @endif"
        tabindex="0"
        @keydown.enter.prevent="toggle()"
        @keydown.space.prevent="toggle()"
        @keydown.escape="close()"
        role="button"
        :aria-expanded="open"
    >
        <span style="flex-shrink:0; display:flex; opacity:0.45;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:0.9375rem;height:0.9375rem;">
                <circle cx="12" cy="12" r="9"/><path d="M12 6v6l4 2"/>
            </svg>
        </span>

        <span style="flex:1; font-size:0.875rem;" :style="!getValue() ? 'opacity:0.45;' : ''" x-text="getValue() || '{{ $placeholder }}'"></span>

        @if($clearable)
            <button type="button" x-show="getValue() !== '00:00'" x-cloak @click.stop="clear()"
                style="display:flex; align-items:center; justify-content:center; width:1.125rem; height:1.125rem; border:none; background:transparent; cursor:pointer; padding:0; color:inherit; opacity:0.5; flex-shrink:0; transition:opacity 120ms;"
                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'" aria-label="Clear time">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:0.75rem;height:0.75rem;">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        @endif

        <span style="flex-shrink:0; display:flex; opacity:0.4; transition:transform 200ms ease;" :style="open ? 'transform:rotate(180deg)' : ''">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </span>
    </div>

    {{-- Panel --}}
    <div x-show="open" x-cloak class="xushi-time-picker-panel" style="display:none;">

        {{-- Columns --}}
        <div style="display:flex; align-items:stretch; padding:0.5rem 0.75rem;">

            {{-- Hours --}}
            <div style="display:flex; flex-direction:column; align-items:center; gap:0.125rem; padding:0.25rem 0.5rem;">
                <button type="button" class="xushi-time-arrow" @click="step('hours', 1)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 15 6-6 6 6"/></svg>
                </button>
                <div style="width:3rem; text-align:center; font-size:1.5rem; font-weight:700; font-variant-numeric:tabular-nums; padding:0.25rem 0; color:var(--xushi-color-base-content);" x-text="pad(hours)"></div>
                <button type="button" class="xushi-time-arrow" @click="step('hours', -1)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <span style="font-size:0.625rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--xushi-color-base-content); opacity:0.4; margin-top:0.25rem;">HH</span>
            </div>

            {{-- Colon --}}
            <div style="display:flex; align-items:center; padding:0 0.125rem; font-size:1.5rem; font-weight:300; color:var(--xushi-color-base-content); opacity:0.3; user-select:none; padding-bottom:1.5rem;">:</div>

            {{-- Minutes --}}
            <div style="display:flex; flex-direction:column; align-items:center; gap:0.125rem; padding:0.25rem 0.5rem;">
                <button type="button" class="xushi-time-arrow" @click="step('minutes', {{ $step }})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 15 6-6 6 6"/></svg>
                </button>
                <div style="width:3rem; text-align:center; font-size:1.5rem; font-weight:700; font-variant-numeric:tabular-nums; padding:0.25rem 0; color:var(--xushi-color-base-content);" x-text="pad(minutes)"></div>
                <button type="button" class="xushi-time-arrow" @click="step('minutes', -{{ $step }})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <span style="font-size:0.625rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--xushi-color-base-content); opacity:0.4; margin-top:0.25rem;">MM</span>
            </div>

            @if($seconds)
                <div style="display:flex; align-items:center; padding:0 0.125rem; font-size:1.5rem; font-weight:300; color:var(--xushi-color-base-content); opacity:0.3; user-select:none; padding-bottom:1.5rem;">:</div>
                <div style="display:flex; flex-direction:column; align-items:center; gap:0.125rem; padding:0.25rem 0.5rem;">
                    <button type="button" class="xushi-time-arrow" @click="step('seconds', 1)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 15 6-6 6 6"/></svg>
                    </button>
                    <div style="width:3rem; text-align:center; font-size:1.5rem; font-weight:700; font-variant-numeric:tabular-nums; padding:0.25rem 0; color:var(--xushi-color-base-content);" x-text="pad(seconds)"></div>
                    <button type="button" class="xushi-time-arrow" @click="step('seconds', -1)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <span style="font-size:0.625rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--xushi-color-base-content); opacity:0.4; margin-top:0.25rem;">SS</span>
                </div>
            @endif

            @if($meridiem)
                <div style="display:flex; flex-direction:column; gap:0.25rem; padding:0.5rem 0.375rem; border-left:1px solid var(--xushi-color-base-border); margin-left:0.5rem; justify-content:center;">
                    <button type="button" @click="period = 'AM'"
                        style="padding:0.375rem 0.625rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; font-weight:600; cursor:pointer; transition:background 100ms;"
                        :style="period === 'AM' ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content);' : 'background:var(--xushi-color-base-neutral); color:var(--xushi-color-base-content);'"
                    >AM</button>
                    <button type="button" @click="period = 'PM'"
                        style="padding:0.375rem 0.625rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; font-weight:600; cursor:pointer; transition:background 100ms;"
                        :style="period === 'PM' ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content);' : 'background:var(--xushi-color-base-neutral); color:var(--xushi-color-base-content);'"
                    >PM</button>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div style="padding:0.5rem 0.75rem; border-top:1px solid var(--xushi-color-base-border); display:flex; justify-content:flex-end; gap:0.5rem;">
            <button type="button" @click="clear()"
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; color:var(--xushi-color-base-content); opacity:0.5; padding:0.25rem 0.5rem; border-radius:var(--xushi-radius-selector); transition:opacity 120ms;"
                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'"
            >Clear</button>
            <button type="button" @click="close()"
                style="border:none; cursor:pointer; font-size:0.8125rem; font-family:inherit; font-weight:500; color:var(--xushi-color-primary-content); background:var(--xushi-color-primary); padding:0.25rem 0.875rem; border-radius:var(--xushi-radius-selector);"
            >OK</button>
        </div>

    </div>
</div>