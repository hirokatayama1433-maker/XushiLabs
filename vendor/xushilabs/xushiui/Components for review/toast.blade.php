@props([
    'position' => 'bottom-right',
    'duration' => 4000,
    'limit' => 5,
    'event' => null,
    'style' => null,
    'isTop' => false,
])

@php
    $positionStyles = [
        'top-left'      => 'top:1rem; left:1rem; align-items:flex-start;',
        'top-center'    => 'top:1rem; left:50%; transform:translateX(-50%); align-items:center;',
        'top-right'     => 'top:1rem; right:1rem; align-items:flex-end;',
        'bottom-left'   => 'bottom:1rem; left:1rem; align-items:flex-start;',
        'bottom-center' => 'bottom:1rem; left:50%; transform:translateX(-50%); align-items:center;',
        'bottom-right'  => 'bottom:1rem; right:1rem; align-items:flex-end;',
    ];
    $posStyle = $positionStyles[$position] ?? $positionStyles['bottom-right'];
    $isTop = str_starts_with($position, 'top');
@endphp

@once
<style>
    .xushi-toast-portal:empty {
        display: none;
    }

    .xushi-toast {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem 1rem;
        background: var(--xushi-color-base-100);
        border: var(--xushi-border-box) solid var(--xushi-color-base-border);
        border-radius: var(--xushi-radius-box);
        box-shadow: var(--xushi-shadow);
        min-width: 280px;
        max-width: 420px;
        box-sizing: border-box;
        pointer-events: all;
    }

    .xushi-toast--success { border-left: 3px solid var(--xushi-color-success); }
    .xushi-toast--danger  { border-left: 3px solid var(--xushi-color-danger);  }
    .xushi-toast--warning { border-left: 3px solid var(--xushi-color-warning); }
    .xushi-toast--info    { border-left: 3px solid var(--xushi-color-info);    }

    .xushi-toast-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .xushi-toast--success .xushi-toast-icon { color: var(--xushi-color-success); }
    .xushi-toast--danger  .xushi-toast-icon { color: var(--xushi-color-danger);  }
    .xushi-toast--warning .xushi-toast-icon { color: var(--xushi-color-warning); }
    .xushi-toast--info    .xushi-toast-icon { color: var(--xushi-color-info);    }

    .xushi-toast-content {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
        flex: 1;
        min-width: 0;
    }

    .xushi-toast-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--xushi-color-base-content);
        line-height: 1.4;
    }

    .xushi-toast-body {
        font-size: 0.8125rem;
        color: var(--xushi-color-base-content);
        opacity: 0.75;
        line-height: 1.5;
    }

    .xushi-toast-close {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 1.25rem;
        height: 1.25rem;
        border: none;
        background: transparent;
        cursor: pointer;
        opacity: 0.4;
        color: var(--xushi-color-base-content);
        transition: opacity 150ms ease;
        padding: 0;
    }

    .xushi-toast-close:hover { opacity: 1; }

    .xushi-toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        background: var(--xushi-color-base-content);
        opacity: 0.15;
        animation: xushi-toast-progress linear forwards;
        border-radius: 0 0 var(--xushi-radius-box) var(--xushi-radius-box);
    }

    .xushi-toast--success .xushi-toast-progress { background: var(--xushi-color-success); }
    .xushi-toast--danger  .xushi-toast-progress { background: var(--xushi-color-danger);  }
    .xushi-toast--warning .xushi-toast-progress { background: var(--xushi-color-warning); }
    .xushi-toast--info    .xushi-toast-progress { background: var(--xushi-color-info);    }

    @keyframes xushi-toast-progress {
        from { width: 100%; }
        to   { width: 0%; }
    }
</style>
@endonce

@once
<script>
    function xushiToast({ duration = 4000, limit = 5, isTop = false } = {}) {
        return {
            toasts: [],

            add({ title, body, type = 'base', duration: d }) {
                const id  = ++_toastId;
                const dur = d ?? duration;

                if (this.toasts.length >= limit) {
                    const oldest = isTop
                        ? this.toasts[this.toasts.length - 1]
                        : this.toasts[0];
                    if (oldest) this.dismiss(oldest.id);
                }

                const toast = { id, title, body, type, duration: dur, visible: true };
                isTop ? this.toasts.unshift(toast) : this.toasts.push(toast);

                if (dur > 0) setTimeout(() => this.dismiss(id), dur);
            },

            dismiss(id) {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) toast.visible = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 400);
            },
        };
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('xushiToast', xushiToast);
    });
</script>
@endonce

    <div
        x-data="xushiToast({ duration: {{ $duration }}, limit: {{ $limit }}, isTop: {{ $isTop ? 'true' : 'false' }} })"
        @xushi-toast.window="add($event.detail)"
        class="xushi-toast-portal"
        style="
            position: fixed;
            z-index: var(--xushi-z-toast);
            display: flex;
            flex-direction: {{ $isTop ? 'column' : 'column-reverse' }};
            gap: 0.5rem;
            pointer-events: none;
        width: max-content;
        max-width: min(22rem, calc(100vw - 2rem));
        {{ $posStyle }}
    "
    aria-live="polite"
    aria-atomic="false"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            class="xushi-toast"
            x-show="toast.visible"
            x-transition:enter="xushi-toast-enter"
            x-transition:enter-start="xushi-toast-enter-start"
            x-transition:enter-end="xushi-toast-enter-end"
            x-transition:leave="xushi-toast-leave"
            x-transition:leave-start="xushi-toast-leave-start"
            x-transition:leave-end="xushi-toast-leave-end"
            :class="`xushi-toast--${toast.type ?? 'base'}`"
            style="pointer-events: auto;"
        >
            {{-- Icon --}}
            <span class="xushi-toast-icon" x-show="toast.type" x-html="xushiToastIcon(toast.type)"></span>

            {{-- Content --}}
            <div class="xushi-toast-content">
                <p class="xushi-toast-title" x-show="toast.title" x-text="toast.title"></p>
                <p class="xushi-toast-body"  x-show="toast.body"  x-text="toast.body"></p>
            </div>

            {{-- Close --}}
            <button
                type="button"
                class="xushi-toast-close"
                @click="dismiss(toast.id)"
                aria-label="Dismiss"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:0.875rem;height:0.875rem;">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>

            {{-- Progress bar --}}
            <div
                class="xushi-toast-progress"
                x-show="toast.duration > 0"
                :style="`animation-duration: ${toast.duration}ms`"
            ></div>
        </div>
    </template>
</div>
