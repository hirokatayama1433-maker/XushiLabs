@props([
    'name' => null,
    'value' => null,
    'min' => null,
    'max' => null,
    'mode' => 'single',
    'showtoday' => true,
    'weeknumbers' => false,
    'firstday' => '0',
    'radius' => null,
    'shadow' => null,
    'border' => null,
    'width' => null,
    'margin' => null,
])

@php
    $style = collect([
        'display' => 'flex',
        'flex-direction' => 'column',
        'background' => 'var(--xushi-color-base-100)',
        'border-radius' => $radius ?? 'var(--xushi-radius-box)',
        'border' => $border ?? '1px solid var(--xushi-color-base-border)',
        'box-shadow' => $shadow,
        'width' => $width ?? 'fit-content',
        'padding' => '0.875rem',
        'margin' => $margin,
        'box-sizing' => 'border-box',
        'min-width' => '18rem',
    ])->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    x-data="xushiCalendar({
        value: {{ $value ? json_encode($value) : 'null' }},
        min: {{ $min ? json_encode($min) : 'null' }},
        max: {{ $max ? json_encode($max) : 'null' }},
        mode: '{{ $mode }}',
        firstDay: {{ $firstday }},
        weekNumbers: {{ $weeknumbers ? 'true' : 'false' }}
    })"
    class="xushi-calendar"
    style="{{ $style }}"
    {{ $attributes->except(['class', 'style']) }}
>
    {{-- Hidden input for form --}}
    @if($name)
        <template x-if="mode === 'single'">
            <input type="hidden" name="{{ $name }}" :value="selected[0] ?? ''">
        </template>
        <template x-if="mode !== 'single'">
            <template x-for="(d, i) in selected" :key="i">
                <input type="hidden" name="{{ $name }}[]" :value="d">
            </template>
        </template>
    @endif

    {{-- Navigation header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
        <button
            type="button"
            @click="prevMonth()"
            class="xushi-cal-nav-btn"
            aria-label="Previous month"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;">
                <path d="m15 6-6 6 6 6"/>
            </svg>
        </button>

        <button
            type="button"
            @click="cycleView()"
            style="border:none; background:transparent; cursor:pointer; font-size:0.9375rem; font-weight:700; font-family:inherit; color:var(--xushi-color-base-content); padding:0.25rem 0.625rem; border-radius:var(--xushi-radius-selector); transition:background 120ms;"
            onmouseover="this.style.background='var(--xushi-color-base-200)'"
            onmouseout="this.style.background='transparent'"
            x-text="viewLabel()"
        ></button>

        <button
            type="button"
            @click="nextMonth()"
            class="xushi-cal-nav-btn"
            aria-label="Next month"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="width:0.875rem;height:0.875rem;">
                <path d="m9 6 6 6-6 6"/>
            </svg>
        </button>
    </div>

    {{-- Days view --}}
    <div x-show="view === 'days'">
        {{-- Weekday headers --}}
        <div style="display:grid; grid-template-columns:{{ $weeknumbers ? '1.5rem ' : '' }}repeat(7,1fr); gap:2px; margin-bottom:0.25rem;">
            @if($weeknumbers)
                <div style=""></div>
            @endif
            <template x-for="day in weekDays()" :key="day">
                <div style="text-align:center; font-size:0.6875rem; font-weight:700; color:var(--xushi-color-base-content-muted); padding:0.25rem 0; text-transform:uppercase; letter-spacing:0.06em;" x-text="day"></div>
            </template>
        </div>

        {{-- Day cells --}}
        <div style="display:grid; grid-template-columns:{{ $weeknumbers ? '1.5rem ' : '' }}repeat(7,1fr); gap:2px;">
            <template x-for="day in calendarDays()" :key="day.iso">
                {{-- Week number cell --}}
                <template x-if="{{ $weeknumbers ? 'true' : 'false' }} && day.isFirstOfWeek">
                    <div style="display:flex; align-items:center; justify-content:center; font-size:0.6875rem; color:var(--xushi-color-base-content-muted); opacity:0.5;" x-text="day.weekNum"></div>
                </template>
                <template x-if="{{ $weeknumbers ? 'true' : 'false' }} && !day.isFirstOfWeek">
                    <template x-if="false"><div></div></template>
                </template>

                <button
                    type="button"
                    @click="day.enabled && selectDate(day.iso)"
                    style="
                        display:flex; align-items:center; justify-content:center;
                        height:2.125rem;
                        border-radius:var(--xushi-radius-selector);
                        border:none; font-family:inherit; font-size:0.8125rem;
                        cursor:pointer; transition:background 100ms ease, color 100ms ease;
                    "
                    :disabled="!day.enabled"
                    :style="dayStyle(day)"
                    :aria-label="day.iso"
                    :aria-selected="isSelected(day.iso)"
                    :aria-pressed="isSelected(day.iso)"
                >
                    <span x-text="day.day"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Month picker view --}}
    <div x-show="view === 'months'" style="display:grid; grid-template-columns:repeat(3,1fr); gap:0.375rem;">
        <template x-for="(m, i) in monthNames()" :key="i">
            <button
                type="button"
                @click="selectMonth(i)"
                style="padding:0.625rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; cursor:pointer; transition:background 100ms;"
                :style="viewMonth === i ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : 'background:transparent; color:var(--xushi-color-base-content);'"
                x-text="m"
                onmouseover="if(!this.style.background.includes('primary')) this.style.background='var(--xushi-color-base-200)'"
                onmouseout="if(!this.style.background.includes('primary')) this.style.background='transparent'"
            ></button>
        </template>
    </div>

    {{-- Year picker view --}}
    <div x-show="view === 'years'" style="display:grid; grid-template-columns:repeat(4,1fr); gap:0.375rem; max-height:14rem; overflow-y:auto;">
        <template x-for="yr in yearRange()" :key="yr">
            <button
                type="button"
                @click="selectYear(yr)"
                style="padding:0.5rem; border-radius:var(--xushi-radius-selector); border:none; font-family:inherit; font-size:0.8125rem; cursor:pointer; transition:background 100ms;"
                :style="viewYear === yr ? 'background:var(--xushi-color-primary); color:var(--xushi-color-primary-content); font-weight:600;' : 'background:transparent; color:var(--xushi-color-base-content);'"
                x-text="yr"
                onmouseover="if(!this.style.background.includes('primary')) this.style.background='var(--xushi-color-base-200)'"
                onmouseout="if(!this.style.background.includes('primary')) this.style.background='transparent'"
            ></button>
        </template>
    </div>

    {{-- Footer --}}
    @if($showtoday)
        <div style="margin-top:0.75rem; padding-top:0.625rem; border-top:1px solid var(--xushi-color-base-border); display:flex; align-items:center; justify-content:space-between;">
            <button
                type="button"
                @click="clearSelection()"
                x-show="selected.length > 0"
                x-cloak
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; color:var(--xushi-color-base-content-muted); padding:0.25rem 0.375rem; border-radius:var(--xushi-radius-selector);"
            >Clear</button>
            <button
                type="button"
                @click="selectToday()"
                style="border:none; background:transparent; cursor:pointer; font-size:0.8125rem; font-family:inherit; font-weight:500; color:var(--xushi-color-primary); padding:0.25rem 0.75rem; border-radius:var(--xushi-radius-selector); margin-left:auto; transition:background 120ms;"
                onmouseover="this.style.background='color-mix(in oklch, var(--xushi-color-primary) 10%, transparent)'"
                onmouseout="this.style.background='transparent'"
            >Today</button>
        </div>
    @endif
</div>
