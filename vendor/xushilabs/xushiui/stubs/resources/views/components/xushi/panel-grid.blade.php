@props([
    'cols' => 4,
    'gap' => '20px',
    'height' => 'auto',
    'devmode' => false,
    'gridId' => null,
])

@once('panel-grid-base')
<style>
    .xushi-panel-grid {
        display: grid;
        width: 100%;
    }

    /* devmode */
    .xushi-panel-grid--dev [data-panel] {
        outline: 2px dashed rgba(99,102,241,0.45);
        position: relative;
    }
    .xushi-panel-grid--dev [data-panel]::before {
        content: attr(data-pg-area);
        position: absolute; top: 4px; right: 6px;
        font-size: 10px; font-family: monospace;
        color: rgba(99,102,241,0.8);
        background: rgba(99,102,241,0.08);
        padding: 1px 6px; border-radius: 3px;
        pointer-events: none;
    }
    .xushi-panel-grid--dev-bar {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 12px; flex-wrap: wrap;
    }
    .xushi-panel-grid--dev-btn {
        font-size: 12px; padding: 4px 12px;
        border: 1px solid #ddd; border-radius: 6px;
        background: #fff; cursor: pointer; color: #555;
    }
    .xushi-panel-grid--dev-btn:hover { background: #f5f5f5; }
    .xushi-panel-grid--dev-btn.active { background: #111; color: #fff; border-color: #111; }
    .xushi-panel-grid--dev-output {
        display: none;
        background: #111; color: #a5f3a5;
        font-family: monospace; font-size: 12px;
        padding: 1rem; border-radius: 8px;
        margin-bottom: 1rem; white-space: pre;
        overflow-x: auto; max-height: 300px; overflow-y: auto;
    }
    .xushi-panel-grid--dev-output.visible { display: block; }
    .xushi-panel-grid--dev-note {
        font-size: 11px; color: #bbb; margin-left: auto;
    }
</style>
@endonce

@once('panel-grid-resolver')
<script>
(function XushiPanelGridResolver() {

    const BREAKPOINTS = [
        { maxWidth: 900, cols: 2 },
        { maxWidth: 600, cols: 1 },
    ];

    function getSpan(el, gridCols) {
        const colAttr = el.getAttribute('data-colspan') || '1';
        const colspan = colAttr === 'full'
            ? gridCols
            : Math.min(parseInt(colAttr) || 1, gridCols);
        const rowspan = Math.max(parseInt(el.getAttribute('data-rowspan')) || 1, 1);
        return { colspan, rowspan };
    }

    function placeItems(panels, gridCols) {
        const grid       = [];
        const panelAreas = new Map();

        function ensureRows(count) {
            while (grid.length < count) grid.push(new Array(gridCols).fill(null));
        }

        function canPlace(row, col, colspan, rowspan) {
            for (let r = row; r < row + rowspan; r++)
                for (let c = col; c < col + colspan; c++) {
                    if (c >= gridCols) return false;
                    if (grid[r]?.[c] != null) return false;
                }
            return true;
        }

        function place(row, col, colspan, rowspan, name) {
            for (let r = row; r < row + rowspan; r++) {
                ensureRows(r + 1);
                for (let c = col; c < col + colspan; c++) grid[r][c] = name;
            }
        }

        panels.forEach((el, i) => {
            const name = `zpg-area-${i}`;
            const { colspan, rowspan } = getSpan(el, gridCols);
            let placed = false;

            outer: for (let r = 0; r < grid.length + rowspan; r++) {
                ensureRows(r + 1);
                for (let c = 0; c <= gridCols - colspan; c++) {
                    if (canPlace(r, c, colspan, rowspan)) {
                        place(r, c, colspan, rowspan, name);
                        panelAreas.set(el, name);
                        placed = true;
                        break outer;
                    }
                }
            }

            if (!placed) {
                ensureRows(grid.length + 1);
                place(grid.length - 1, 0, 1, 1, name);
                panelAreas.set(el, name);
            }
        });

        return { grid, panelAreas };
    }

    function buildCss(gridId, grid, cols, panelAreas, panels, mediaMax) {
        const areas = grid.map(row => `"${row.map(c => c ?? '.').join(' ')}"`).join('\n    ');

        let css = `.${gridId} {\n` +
                  `  grid-template-columns: repeat(${cols}, 1fr);\n` +
                  `  grid-template-areas:\n    ${areas};\n` +
                  `}\n`;

        panels.forEach((el, i) => {
            const area = panelAreas.get(el);
            if (area) css += `.${gridId} [data-pg-index="${i}"] { grid-area: ${area}; }\n`;
        });

        if (mediaMax != null) {
            return `@media (max-width: ${mediaMax}px) {\n` +
                css.split('\n').map(l => l ? '  ' + l : '').join('\n') +
                `\n}`;
        }
        return css;
    }

    const debugData = new Map();

    function resolveGrid(container) {
        const cols   = parseInt(container.getAttribute('data-cols')) || 4;
        const gridId = container.getAttribute('data-grid-id');

        const panels = Array.from(container.children).filter(el => el.hasAttribute('data-panel'));
        panels.forEach((el, i) => el.setAttribute('data-pg-index', i));

        const desktop  = placeItems(panels, cols);

        // stamp area name on each panel for devmode ::before label
        panels.forEach(el => {
            el.setAttribute('data-pg-area', desktop.panelAreas.get(el) ?? '');
        });

        const bpResults = BREAKPOINTS.map(bp => {
            const { grid, panelAreas } = placeItems(panels, bp.cols);
            return { ...bp, grid, panelAreas };
        });

        // store for debug output
        debugData.set(gridId, { cols, panels: panels.length, desktop, breakpoints: bpResults });

        return [
            buildCss(gridId, desktop.grid, cols, desktop.panelAreas, panels),
            ...bpResults.map(bp => buildCss(gridId, bp.grid, bp.cols, bp.panelAreas, panels, bp.maxWidth)),
        ].join('\n\n');
    }

    function run() {
        let css = '';
        document.querySelectorAll('[data-panel-grid]').forEach(c => css += resolveGrid(c) + '\n');
        let el = document.getElementById('zpg-resolver-styles');
        if (!el) {
            el = document.createElement('style');
            el.id = 'zpg-resolver-styles';
            document.head.appendChild(el);
        }
        el.textContent = css;

        // refresh any visible debug outputs
        document.querySelectorAll('.xushi-panel-grid--dev-output.visible').forEach(out => {
            const gridId = out.dataset.for;
            if (gridId) out.textContent = buildDebugText(gridId);
        });
    }

    function buildDebugText(gridId) {
        const d = debugData.get(gridId);
        if (!d) return '';
        const lines = [];
        lines.push(`Grid: ${gridId} | cols: ${d.cols} | panels: ${d.panels} | rows: ${d.desktop.grid.length}`);
        lines.push('Template areas (desktop):');
        d.desktop.grid.forEach(row => lines.push('  ' + row.map(c => (c ?? '.').padEnd(16)).join('')));
        d.breakpoints.forEach(bp => {
            lines.push(`Template areas (≤${bp.maxWidth}px, ${bp.cols}-col):`);
            bp.grid.forEach(row => lines.push('  ' + row.map(c => (c ?? '.').padEnd(16)).join('')));
        });
        return lines.join('\n');
    }

    // expose for devmode bars
    window.XushiPanelGridResolver = { run, buildDebugText };

    document.addEventListener('DOMContentLoaded', () => {
        run();
        let t;
        window.addEventListener('resize', () => { clearTimeout(t); t = setTimeout(run, 100); });
    });

})();
</script>
@endonce

@php
    $gridId ??= 'zpg-' . substr(md5(uniqid()), 0, 8);
@endphp

@if($devmode)
<div class="xushi-panel-grid--dev-bar">
    <button
        class="xushi-panel-grid--dev-btn"
        onclick="
            const out = document.querySelector('.xushi-panel-grid--dev-output[data-for=\'{{ $gridId }}\']');
            const on = out.classList.toggle('visible');
            this.classList.toggle('active', on);
            this.textContent = on ? 'Hide debug output' : 'Show debug output';
            if (on) out.textContent = window.XushiPanelGridResolver.buildDebugText('{{ $gridId }}');
        "
    >Show debug output</button>
    <button
        class="xushi-panel-grid--dev-btn"
        onclick="
            const grid = document.querySelector('.{{ $gridId }}');
            const on = grid.classList.toggle('xushi-panel-grid--dev');
            this.classList.toggle('active', on);
            this.textContent = on ? 'Hide grid outlines' : 'Show grid outlines';
        "
    >Show grid outlines</button>
    <span class="xushi-panel-grid--dev-note">↔ Resize window to see breakpoints</span>
</div>
<pre class="xushi-panel-grid--dev-output" data-for="{{ $gridId }}"></pre>
@endif

<div
    class="xushi-panel-grid {{ $gridId }}"
    data-panel-grid
    data-grid-id="{{ $gridId }}"
    data-cols="{{ $cols }}"
    style="gap: {{ $gap }}; height: {{ $height }};"
    {{ $attributes }}
>
    {{ $slot }}
</div>
