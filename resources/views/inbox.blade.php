<x-layouts.layout title="Dashboard">

    <xushi:heading level="2">Good afternoon, User!</xushi:heading>

    <xushi:text variant="muted">
        Welcome to your dashboard. Here you can manage your account, view your activity, and access various features.
    </xushi:text>

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
    h1 { font-size: 1.1rem; font-weight: 600; color: #555; margin-bottom: 0.25rem; }
    p.sub { font-size: 0.8rem; color: #999; margin-bottom: 1.5rem; }
 
    /* ─── Panel Grid ─────────────────────────────────────── */
    [data-panel-grid] {
        width: 100%;
        display: grid;
        gap: var(--pg-gap, 20px);
        /* grid-template-* injected by resolver */
    }
 
    /* ─── Panel ──────────────────────────────────────────── */
    [data-panel] {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
 
    /* ─── Demo internals ─────────────────────────────────── */
    .box-label {
        font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.06em; color: #aaa;
    }
    .box-value { font-size: 30px; font-weight: 700; color: #111; line-height: 1; }
    .box-sub   { font-size: 13px; color: #777; }
 
    .badge {
        display: inline-block; font-size: 11px;
        padding: 3px 10px; border-radius: 99px;
        font-weight: 500; width: fit-content;
    }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-red   { background: #fee2e2; color: #991b1b; }
 
    .box-img { width: 100%; height: 100%; object-fit: cover; border-radius: 6px; display: block; flex: 1; }
    [data-panel].no-pad { padding: 0; }
    [data-panel].no-pad .box-img { border-radius: 10px; }
 
    .activity-item {
        display: flex; align-items: center; gap: 12px;
        padding: 8px 0; border-bottom: 1px solid #f3f3f3;
        font-size: 13px; color: #333;
    }
    .activity-item:last-child { border-bottom: none; }
    .avatar { width: 30px; height: 30px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .activity-time { margin-left: auto; color: #bbb; font-size: 11px; }
 
    .quick-action {
        display: block; padding: 10px 12px;
        background: #f7f7f7; border-radius: 7px;
        font-size: 13px; color: #333; text-decoration: none;
    }
    .quick-action:hover { background: #efefef; }
 
    /* ─── Debug ──────────────────────────────────────────── */
    .debug-bar { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
    .debug-btn {
        font-size: 12px; padding: 5px 12px;
        border: 1px solid #ddd; border-radius: 6px;
        background: #fff; cursor: pointer; color: #555;
    }
    .debug-btn:hover { background: #f5f5f5; }
    .debug-btn.active { background: #111; color: #fff; border-color: #111; }
    .debug-panel {
        display: none; background: #111; color: #a5f3a5;
        font-family: monospace; font-size: 12px;
        padding: 1rem; border-radius: 8px;
        margin-bottom: 1.5rem; white-space: pre; overflow-x: auto;
        height: 300px;
    }
    .debug-panel.visible { display: block; min-height: 300px; }
    .resize-note { font-size: 11px; color: #bbb; margin-left: auto; }
 
    [data-panel-grid].debug-mode [data-panel] {
        outline: 2px dashed rgba(99,102,241,0.4);
        position: relative;
         
    }
    [data-panel-grid].debug-mode [data-panel]::before {
        content: attr(data-pg-area);
        position: absolute; top: 4px; right: 6px;
        font-size: 10px; font-family: monospace;
        color: rgba(99,102,241,0.7);
        background: rgba(99,102,241,0.08);
        padding: 1px 5px; border-radius: 3px;
    }
</style>
</head>
<body>
 
<h1>PanelGrid Resolver — XushiUI Prototype</h1>
<p class="sub">JS reads <code>data-panel</code> hierarchy → builds <code>grid-template-areas</code> + responsive breakpoints automatically.</p>
 
<div class="debug-bar">
    <button class="debug-btn" id="toggleDebug">Show debug output</button>
    <button class="debug-btn" id="toggleGrid">Show grid outlines</button>
    <span class="resize-note">↔ Resize window to see breakpoints</span>
</div>
 
<pre class="debug-panel" id="debugPanel"></pre>
 
<!--
    API:
      data-panel-grid   → grid container
        cols="4"        → desktop column count (default 4)
        gap="20px"      → grid gap (default 20px)
 
      data-panel        → panel child
        colspan="N"     → col span (default 1; "full" = all cols)
        rowspan="N"     → row span (default 1)
-->
 
<div data-panel-grid cols="3" gap="20px">

    <!-- Row 1 -->
    <div data-panel colspan="1" rowspan="2">
        <span class="box-label">Transaction</span>
        <span class="box-value">2 · 5 · 9</span>
        <span class="box-sub">Level 1 · Level 2 · Level 3</span>
    </div>

    <div data-panel colspan="1" rowspan="2">
        <span class="box-label">Total Revenue</span>
        <span class="box-value">9k · 4k · 7k</span>
        <span class="box-sub">Items</span>
    </div>

    <div data-panel colspan="1" rowspan="3">
        <span class="box-label">Marketing</span>
        <span class="box-sub">Object 1 — 5%</span>
        <span class="box-sub">Object 2 — 16%</span>
        <span class="box-sub">Object 3 — 34%</span>
        <span class="box-sub">Object 4 — 45%</span>
    </div>

    <!-- Row 2 -->
    <div data-panel colspan="2" rowspan="3">
        <span class="box-label">Production Funding</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
        <span class="box-sub">Monthly Capacity — 6K 11K 18K 10K 15K 5K 7K</span>
    </div>

    <!-- Row 3 -->
    <div data-panel colspan="1" rowspan="5">
        <span class="box-label">Active Statistics</span>
        <span class="box-value">90c / 25c</span>
        <span class="box-sub">Total Speed · Acc 1 · Acc 2 · Acc 3</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        
    </div>

    <div data-panel colspan="1" rowspan="3">
        <span class="box-label">Statistics</span>
        <span class="box-value">51%</span>
        <span class="box-sub">August · 35% July</span>
    </div>

    <div data-panel colspan="1" rowspan="3">
        <span class="box-label">Category — In Progress</span>
        <span class="box-value">375 Items</span>
        <span class="box-sub">22% · 15% · 19% · 28% · 16%</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
        <span class="box-sub">2.1 · 3.7 · 5.2 · 3.2 · 4.6 Total Statistics</span>
    </div>

    <!-- Row 4: left 3 cols empty, Category continues in col 4 -->
    <div data-panel colspan="3">
        <span class="box-label">Extended Stats</span>
        <span class="box-sub">Placeholder for additional content</span>
    </div>

</div>


 
<script>
        (function PanelGridResolver() {
        
            const BREAKPOINTS = [
                { maxWidth: 900, cols: 2 },
                { maxWidth: 600, cols: 1 },
            ];
        
            // ── Parse colspan/rowspan from element ────────────────────────────
            function getSpan(el, gridCols) {
                const colAttr = el.getAttribute('colspan') || '1';
                const colspan = colAttr === 'full'
                    ? gridCols
                    : Math.min(parseInt(colAttr) || 1, gridCols);
                const rowspan = Math.max(parseInt(el.getAttribute('rowspan')) || 1, 1);
                return { colspan, rowspan };
            }
        
            // ── 2D placement algorithm ────────────────────────────────────────
            function placeItems(panels, gridCols) {
                const grid       = [];   // 2D: grid[row][col] = areaName | null
                const panelAreas = new Map();
        
                function ensureRows(count) {
                    while (grid.length < count) {
                        grid.push(new Array(gridCols).fill(null));
                    }
                }
        
                function canPlace(row, col, colspan, rowspan) {
                    for (let r = row; r < row + rowspan; r++) {
                        for (let c = col; c < col + colspan; c++) {
                            if (c >= gridCols) return false;
                            if (grid[r]?.[c] != null) return false;
                        }
                    }
                    return true;
                }
        
                function place(row, col, colspan, rowspan, name) {
                    for (let r = row; r < row + rowspan; r++) {
                        ensureRows(r + 1);
                        for (let c = col; c < col + colspan; c++) {
                            grid[r][c] = name;
                        }
                    }
                }
        
                panels.forEach((el, i) => {
                    const name = `pg-area-${i}`;
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
                        for (let r = 0; r < grid.length + 1; r++) {
                            ensureRows(r + 1);
                            for (let c = 0; c < gridCols; c++) {
                                if (grid[r][c] == null) {
                                    place(r, c, Math.min(colspan, gridCols - c), rowspan, name);
                                    panelAreas.set(el, name);
                                    placed = true;
                                    break;
                                }
                            }
                            if (placed) break;
                        }
                    }
                });
        
                return { grid, panelAreas };
            }
        
            // ── Build CSS block (container + per-panel grid-area rules) ───────
            function buildBlock(id, grid, cols, panelAreas, panels, mediaMax) {
                const areas = grid.map(row => `"${row.map(c => c ?? '.').join(' ')}"`).join('\n');
        
                let css = `[data-panel-grid][data-pg-id="${id}"] {\n` +
                        `  grid-template-columns: repeat(${cols}, 1fr);\n` +
                        `  grid-template-areas:\n    ${areas.split('\n').join('\n    ')};\n` +
                        `}\n`;
        
                panels.forEach((el, i) => {
                    const area = panelAreas.get(el);
                    if (area) css += `[data-panel-grid][data-pg-id="${id}"] [data-pg-index="${i}"] { grid-area: ${area}; }\n`;
                });
        
                if (mediaMax != null) {
                    return `@media (max-width: ${mediaMax}px) {\n` +
                        css.split('\n').map(l => l ? '  ' + l : '').join('\n') +
                        `\n}`;
                }
                return css;
            }
        
            // ── Main ──────────────────────────────────────────────────────────
            let styleEl = null;
            const debugLog = [];
        
            function resolveGrid(container, index) {
                const cols  = parseInt(container.getAttribute('cols')) || 4;
                const gap   = container.getAttribute('gap') || '20px';
                const pgId  = `pg-${index}`;
        
                container.dataset.pgId = pgId;
                container.style.gap    = gap;
                container.style.gridTemplateColumns = '';
                container.style.gridTemplateAreas   = '';
        
                const panels = Array.from(container.children).filter(el => el.hasAttribute('data-panel'));
                panels.forEach((el, i) => { el.dataset.pgIndex = i; });
        
                const desktop = placeItems(panels, cols);
                panels.forEach((el) => { el.dataset.pgArea = desktop.panelAreas.get(el) ?? ''; });
        
                const bpResults = BREAKPOINTS.map(bp => {
                    const { grid, panelAreas } = placeItems(panels, bp.cols);
                    return { maxWidth: bp.maxWidth, cols: bp.cols, grid, panelAreas };
                });
        
                const blocks = [
                    buildBlock(pgId, desktop.grid, cols, desktop.panelAreas, panels),
                    ...bpResults.map(bp => buildBlock(pgId, bp.grid, bp.cols, bp.panelAreas, panels, bp.maxWidth)),
                ];
        
                debugLog.push({ pgId, cols, gap, panels: panels.length, desktop, breakpoints: bpResults });
                return blocks.join('\n\n');
            }
        
            function inject(css) {
                if (!styleEl) {
                    styleEl = document.createElement('style');
                    styleEl.id = 'panel-grid-resolver';
                    document.head.appendChild(styleEl);
                }
                styleEl.textContent = css;
            }
        
            function run() {
                debugLog.length = 0;
                const all = [];
                document.querySelectorAll('[data-panel-grid]').forEach((c, i) => all.push(resolveGrid(c, i)));
                inject(all.join('\n\n'));
                renderDebug();
            }
        
            // ── Debug ─────────────────────────────────────────────────────────
            function renderDebug() {
                const el = document.getElementById('debugPanel');
                if (!el?.classList.contains('visible')) return;
                const lines = [];
                debugLog.forEach(d => {
                    lines.push(`Grid: ${d.pgId} | cols: ${d.cols} | gap: ${d.gap} | panels: ${d.panels} | rows: ${d.desktop.grid.length}`);
                    lines.push('Template areas (desktop):');
                    d.desktop.grid.forEach(row => lines.push('  ' + row.map(c => (c ?? '.').padEnd(14)).join('')));
        
                    d.breakpoints.forEach(bp => {
                        lines.push(`Template areas (≤${bp.maxWidth}px, ${bp.cols}-col):`);
                        bp.grid.forEach(row => lines.push('  ' + row.map(c => (c ?? '.').padEnd(14)).join('')));
                    });
        
                    lines.push('─'.repeat(60));
                });
                el.textContent = lines.join('\n');
            }
        
            document.addEventListener('DOMContentLoaded', () => {
                run();
        
                document.getElementById('toggleDebug').addEventListener('click', function () {
                    const panel = document.getElementById('debugPanel');
                    const on = panel.classList.toggle('visible');
                    this.classList.toggle('active', on);
                    this.textContent = on ? 'Hide debug output' : 'Show debug output';
                    renderDebug();
                });
        
                document.getElementById('toggleGrid').addEventListener('click', function () {
                    const on = this.classList.toggle('active');
                    document.querySelectorAll('[data-panel-grid]').forEach(g => g.classList.toggle('debug-mode', on));
                    this.textContent = on ? 'Hide grid outlines' : 'Show grid outlines';
                });
        
                let t;
                window.addEventListener('resize', () => { clearTimeout(t); t = setTimeout(run, 100); });
            });
        
        })();
        </script>

</x-layouts.layout>