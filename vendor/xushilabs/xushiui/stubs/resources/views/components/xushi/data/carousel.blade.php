@props([
    'autoplay' => false,
    'interval' => 4000,
    'loop' => true,
    'arrows' => true,
    'dots' => true,
    'transition' => 'slide',
    'height' => null,
    'radius' => null,
    'margin' => null,
])

@php
    $style = collect([
        'position' => 'relative',
        'overflow' => 'hidden',
        'width' => '100%',
        'height' => $height,
        'border-radius' => $radius ?? 'var(--xushi-radius-box)',
        'margin' => $margin,
    ])->filter(fn($value) => ! is_null($value) && $value !== '')
        ->map(fn($value, $key) => "$key: $value")
        ->implode('; ');
@endphp

@once
<style>
    .xushi-carousel {
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .xushi-carousel-track {
        display: flex;
        transition: transform 350ms cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform;
    }

    .xushi-carousel-slide {
        flex-shrink: 0;
        width: 100%;
    }
</style>
@endonce

@once
<script>
    function xushiCarousel({ loop = true, autoplay = false, interval = 4000, transition = 'slide' } = {}) {
        return {
            current: 0,
            count: 0,
            loop,
            autoplay,
            interval,
            transition,
            timer: null,

            init() {
                this.$nextTick(() => {
                    this.count = this.$refs.track?.children.length ?? 0;
                    if (this.autoplay) this.startAutoplay();
                });
            },

            goTo(index) {
                if (index < 0)           index = this.loop ? this.count - 1 : 0;
                if (index >= this.count) index = this.loop ? 0 : this.count - 1;
                this.current = index;
            },

            prev() { this.goTo(this.current - 1); },
            next() { this.goTo(this.current + 1); },

            startAutoplay() {
                this.stopAutoplay();
                this.timer = setInterval(() => this.next(), this.interval);
            },

            stopAutoplay() {
                if (this.timer) { clearInterval(this.timer); this.timer = null; }
            },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiCarousel', xushiCarousel);
    });
</script>
@endonce

<div
    x-data="xushiCarousel({
        loop: {{ $loop ? 'true' : 'false' }},
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        interval: {{ $interval }},
        transition: '{{ $transition }}'
    })"
    x-init="init()"
    class="xushi-carousel"
    style="{{ $style }}"
    {{ $attributes }}
>
    {{-- Track --}}
    <div
        class="xushi-carousel-track"
        x-ref="track"
        style="
            display: flex;
            height: 100%;
            transition: transform 400ms cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        "
        :style="transition === 'slide' ? `transform: translateX(-${current * 100}%)` : ''"
    >
        {{ $slot }}
    </div>

    {{-- Arrows --}}
    @if($arrows)
        <button
            type="button"
            class="xushi-carousel-arrow xushi-carousel-arrow--prev"
            @click="prev()"
            aria-label="Previous slide"
            style="
                position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
                width:2.25rem; height:2.25rem; border-radius:999px;
                background:color-mix(in oklch, var(--xushi-color-base-100) 85%, transparent);
                border:none; cursor:pointer; display:flex; align-items:center; justify-content:center;
                color:var(--xushi-color-base-content); backdrop-filter:blur(4px);
                transition:background 150ms ease; z-index:2;
                box-shadow:var(--xushi-shadow);
            "
            onmouseover="this.style.background='var(--xushi-color-base-100)'"
            onmouseout="this.style.background='color-mix(in oklch, var(--xushi-color-base-100) 85%, transparent)'"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="width:1rem;height:1rem;">
                <path d="m15 6-6 6 6 6"/>
            </svg>
        </button>

        <button
            type="button"
            class="xushi-carousel-arrow xushi-carousel-arrow--next"
            @click="next()"
            aria-label="Next slide"
            style="
                position:absolute; right:0.75rem; top:50%; transform:translateY(-50%);
                width:2.25rem; height:2.25rem; border-radius:999px;
                background:color-mix(in oklch, var(--xushi-color-base-100) 85%, transparent);
                border:none; cursor:pointer; display:flex; align-items:center; justify-content:center;
                color:var(--xushi-color-base-content); backdrop-filter:blur(4px);
                transition:background 150ms ease; z-index:2;
                box-shadow:var(--xushi-shadow);
            "
            onmouseover="this.style.background='var(--xushi-color-base-100)'"
            onmouseout="this.style.background='color-mix(in oklch, var(--xushi-color-base-100) 85%, transparent)'"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" style="width:1rem;height:1rem;">
                <path d="m9 6 6 6-6 6"/>
            </svg>
        </button>
    @endif

    {{-- Dots --}}
    @if($dots)
        <div
            class="xushi-carousel-dots"
            style="
                position:absolute; bottom:0.75rem; left:50%; transform:translateX(-50%);
                display:flex; gap:0.375rem; z-index:2;
            "
        >
            <template x-for="(_, i) in count" :key="i">
                <button
                    type="button"
                    @click="goTo(i)"
                    :aria-label="`Slide ${i + 1}`"
                    :aria-current="current === i"
                    style="
                        width:0.5rem; height:0.5rem; border-radius:999px;
                        border:none; cursor:pointer; padding:0;
                        transition: width 250ms ease, background 250ms ease;
                    "
                    :style="current === i
                        ? 'width:1.25rem; background:var(--xushi-color-primary);'
                        : 'background:color-mix(in oklch, var(--xushi-color-base-100) 70%, transparent);'"
                ></button>
            </template>
        </div>
    @endif
</div>
