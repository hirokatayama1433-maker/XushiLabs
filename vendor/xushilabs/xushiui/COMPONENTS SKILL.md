---
name: xushi-component
description: Rules and templates for writing, reviewing, moving or adding XushiUI Blade components (Laravel + Blade + Alpine, CSS-token-driven, no Tailwind). Use whenever creating or editing a file under stubs/resources/views/components/xushi/, reviewing a batch from "Components for review", or touching xushi.css, xushi.js or XushiThemes.php.
---

# Xushi Component Skill

## Stack and ground rules

- Laravel package `xushilabs/xushiui`, namespace `Xushi\UI`. Tags are `<xushi:name>`.
- Blade anonymous components + Alpine.js 3. No Tailwind. No build step.
- Component files live in `stubs/resources/views/components/xushi/{name}.blade.php`: flat, kebab-case. Family children are `{parent}-{child}` (`accordion-item`, `sidebar-navitem`). The tag equals the filename. Never use dots or subfolders for components.
- Layouts and auth stubs live in `stubs/resources/views/components/{layouts,auth}/`.
- Layout order in `<head>`: `@xushiAppearance`, then `@xushiStyles`. `@xushiScripts` goes before `</body>`, and Alpine loads after it.
- Components under review live in `Components for review/` at the package root. A batch is moved into `stubs/` only after approval. Never keep two copies.

## File anatomy (order is mandatory)

```blade
@props([
    'variant' => 'solid',
    'color'   => 'primary',
])

@once
    <style>
        /* -- Example -- */
        .xushi-example { background: var(--xushi-color-base-foreground); }
    </style>
@endonce

@once
    <script>
        document.addEventListener('alpine:init', () => {
            try {
                Alpine.data('xushiExample', (config = {}) => ({
                    open: false,
                }));
            } catch (e) {
                console.error('[Xushi] xushiExample failed to register', e);
            }
        });
    </script>
@endonce

@php
    $colors = ['primary' => 'var(--xushi-color-primary)'];
    $resolved = $colors[$color] ?? $colors['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'xushi-example']) }} style="--xushi-example-color: {{ $resolved }}">
    {{ $slot }}
</div>
```

Rules per zone:

- **Props**: all lowercase, no separators (`bordercolor`, `radiusbottom`, `showvalue`), always with a default. Enumerated values go through a lookup array with a fallback, so an unknown value never crashes.
- **Style**: static CSS only. Classes are `.xushi-{name}` and `.xushi-{name}-{part}`. No element selectors, no rules that target another component's classes. Per-instance values are passed as CSS custom properties on the `style` attribute, never by generating CSS.
- **Script**: only when Alpine logic is needed. One `Alpine.data` per component, named `xushi{PascalName}`, registered in its own `alpine:init` listener inside try/catch. No top-level side effects and no new globals.
- **@php**: resolve, validate, normalise. No queries, no side effects.
- **HTML**: `$attributes` on the root element, with roles and aria attributes.
- **Form components** carry this comment and put `$attributes` on the native element, not the wrapper: `{{-- Attributes pass through to the native element: wire:model, x-model, :disabled, @input, @change, @blur, name, id --}}`

## Loose coupling (the core rules)

1. **Own your names.** CSS classes `xushi-{name}-*`, Alpine data `xushi{Name}`, events `xushi:{name}-{event}`, private tokens `--xushi-{name}-*`. Nothing else in the file is global.
2. **Own your code.** Component-specific CSS and JS live in the blade, never in `xushi.css` or `xushi.js`. Adding a component is adding one file. Removing one is deleting one file.
3. **Shared services are optional at runtime.** Call them with guards (`typeof xushiPosition === 'function'`, `window.Xushi?.Theme`). If a service is missing the component degrades, it does not throw.
4. **Talk through events and attributes, not references.** Never read another component's Alpine scope or classes. Cross-component events use the `xushi:` prefix, for example `xushi:sidebar-toggled`.
5. **Contain failures.** Every `<script>` block is independent, and registration is wrapped in try/catch, so one failing component cannot stop the others from registering.
6. **A family is a unit.** Parent and children (accordion + accordion-item, tab + tab-item + tab-panel, table + table-cell + table-head, carousel + carousel-slide, timeline + timeline-item, breadcrumbs + breadcrumb-item, sidebar-*, header-*) share a contract documented in the parent. A child rendered outside its parent must not crash.
7. **Tokens are the only styling interface.** Read `--xushi-*` tokens with a fallback where sensible. Never hardcode colors. Never use a token that is not defined (check with the grep below). A private token is defined inside the component's own style block.
8. **No hardcoded registries.** Component lists in PHP or JS are forbidden. `PublishCommand`, the tag compiler and the service provider discover files from disk.

## Shared services (tier 1) - the only cross-component surface

- `xushiPosition(trigger, panel)` and `XushiOverlayStack`: positioning and stacking for overlays.
- `Xushi.Theme`: `parts()`, `set(key)`, `setMode`, `setPalette`, `setAccent`, `setLayout`, `toggle`. Event `xushi-theme-changed` (spelling pending decision).
- `Xushi.Sidebar` and event `xushi:sidebar-toggled`.
- Calendar engine `_buildCalendarDays`, `_weekNum` (used by calendar and date-picker).
- `XushiToast`, `xushiToastIcon`, `xushiTableSort`, `xushiSidebarScrollCheck`, and the input action handler (`data-xushi-input-action`).

Adding to this list needs a reason: at least two components must use it and it must be guarded at every call site.

## Tokens

Canonical (defined by `XushiThemes.php` and `:root` in `xushi.css`):

- Color: `base-background`, `base-foreground`, `base-neutral`, `base-content`, `base-content-subtle`, `sidebar`, `header`, `primary`, `primary-content`, `secondary`, `secondary-content`, `danger`, `success`, `warning`, `info` (each with `-content`), all as `--xushi-color-*`.
- Shape: `--xushi-radius-box`, `--xushi-radius-field`, `--xushi-radius-selector`, `--xushi-border-box`, `--xushi-border-field`, `--xushi-border-selector`, `--xushi-size-field`, `--xushi-size-selector`, `--xushi-shadow`.
- Layers: `--xushi-z-*` (drawer 1010, modal 1020, dropdown 1030, popover 1040, tooltip 1050, toast 1060).

Bridge tokens (`XushiThemes::$derived`) exist only so legacy markup renders: `base-100`, `base-200`, `base-300`, `base-border`, `base-content-muted`, `accent`, `accent-content`, `sidebar-content`, `custom-sidebar-content`, `custom-layout-shadow`. New code uses canonical tokens. Whether to rename or keep each bridge is decided during the review.

Check a file for tokens it uses:

```bash
grep -oE 'var\(--xushi-[a-z0-9-]+' path/to/file.blade.php | sort -u
```

## Icons

Use `<xushi:icon name="trash" size="1em" />` only. Names come from `src/Icons/IconMap.php`. An unknown name renders nothing. Arbitrary markup goes through a named slot. No pasted inline SVG and no external requests.

## Adding a new component

1. Create `stubs/resources/views/components/xushi/{name}.blade.php` following the anatomy above.
2. Touch nothing else. If you feel you need to edit `xushi.css`, `xushi.js` or any PHP file, you are adding a shared service, not a component: stop and justify it.
3. Verify: no `zayne` strings, no undefined tokens, no new globals, renders with no other component present, and deleting the file breaks nothing else.

## Review checklist (per component)

- Zones in order; `@once` used; static CSS only.
- Classes and Alpine names correctly prefixed; no new globals.
- Tokens defined; no hardcoded colors; layout variants respected.
- Registration guarded; shared services called defensively.
- Attribute pass-through correct (form components: native element).
- Accessible (role, aria, keyboard); icons via `<xushi:icon>`.
- Works standalone; family contract documented in the parent.

## Batch workflow

1. Receive 3-4 files (`cat` output).
2. Review and fix them in `Components for review/`.
3. On approval: `mv "Components for review/{name}.blade.php" stubs/resources/views/components/xushi/`.
4. Never claim a component works without a render test.

## Never

- Tailwind classes, external CDN calls from components, or `localStorage` outside the Theme and Sidebar services.
- Component-specific code in `xushi.css` or `xushi.js`.
- Any `zayne` naming.
