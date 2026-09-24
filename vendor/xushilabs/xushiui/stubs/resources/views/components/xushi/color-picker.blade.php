@props([
    'pickerId' => null,
    'value' => null,
    'name' => 'color',
    'format' => 'hex',
    'alpha' => false,
    'swatches' => [],
    'closeButton' => null,
    'clearButton' => null,
    'mode' => 'popover',
    'layout' => 'vertical',
    'placeholder' => null,
    'theme' => 'light',
    'defaultSwatches' => [],
    'expandedSwatches' => [],
    'style' => null,
])

@php
$pid            = $pickerId ?? 'xushi_clr_fallback';
$initial        = $value ?? '#6366f1';
$isAlpha        = $alpha ?? false;
$isClear        = $clearButton ?? false;
$isClose        = $closeButton ?? false;
$compName       = $name ?? 'color';
$compTheme      = $theme ?? 'light';
$compFormat     = strtolower($format ?? 'hex');
$defaultSwatches  = $defaultSwatches ?? $swatches ?? [];
$expandedSwatches = $expandedSwatches ?? [];
@endphp

<div class="xushi-picker-wrap {{ $compTheme }}" id="{{ $pid }}" style="{{ $style ?? '' }}">
  @once
  <style>
    .xushi-picker-wrap { --zp-bg: #fff; --zp-fg: #333; --zp-muted: #999; --zp-border: #e8e8e8; --zp-hover: #f0f0f0; --zp-input-bg: #fff; --zp-input-border: #e0e0e0; --zp-shadow: 0 4px 24px rgba(0,0,0,0.12); }
    .xushi-picker-wrap.dark { --zp-bg: #1e1e1e; --zp-fg: #eee; --zp-muted: #888; --zp-border: #333; --zp-hover: #2a2a2a; --zp-input-bg: #2a2a2a; --zp-input-border: #444; --zp-shadow: 0 4px 24px rgba(0,0,0,0.4); }
    .xushi-picker-wrap * { box-sizing: border-box; margin: 0; padding: 0; }
    .xushi-picker-wrap .zp-card { width: 280px; border-radius: 14px; padding: 14px; display: flex; flex-direction: column; gap: 12px; background: var(--zp-bg); border: 1px solid var(--zp-border); box-shadow: var(--zp-shadow); user-select: none; transition: width 250ms ease; }
    .xushi-picker-wrap .zp-card.expanded { width: 640px; }
    .xushi-picker-wrap .zp-header { display: flex; align-items: center; justify-content: space-between; }
    .xushi-picker-wrap .zp-tabs { display: flex; gap: 4px; }
    .xushi-picker-wrap .zp-tab { padding: 5px 12px; border-radius: 8px; border: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.15s; background: transparent; color: var(--zp-muted); }
    .xushi-picker-wrap .zp-tab:hover { color: var(--zp-fg); background: var(--zp-hover); }
    .xushi-picker-wrap .zp-tab.active { color: var(--zp-fg); background: var(--zp-hover); box-shadow: inset 0 0 0 1px var(--zp-border); }
    .xushi-picker-wrap .zp-preview { width: 32px; height: 20px; border-radius: 6px; overflow: hidden; position: relative; border: 1px solid rgba(0,0,0,0.1); }
    .xushi-picker-wrap .zp-view { display: flex; flex-direction: column; gap: 10px; }
    .xushi-picker-wrap .zp-hidden { display: none !important; }
    .xushi-picker-wrap .zp-palette { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; }
    .xushi-picker-wrap .zp-palette-big { display: grid; grid-template-columns: repeat(19, 1fr); gap: 5px; }
    .xushi-picker-wrap .zp-swatch { aspect-ratio: 1; border-radius: 8px; cursor: pointer; transition: transform 0.1s, box-shadow 0.1s; border: 1px solid rgba(0,0,0,0.06); }
    .xushi-picker-wrap .zp-swatch:hover { transform: scale(1.12); box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 2; }
    .xushi-picker-wrap .zp-expand { aspect-ratio: 1; border-radius: 8px; cursor: pointer; transition: all 0.15s; border: 1px solid var(--zp-border); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 500; background: transparent; color: var(--zp-muted); }
    .xushi-picker-wrap .zp-expand:hover { background: var(--zp-hover); color: var(--zp-fg); }
    .xushi-picker-wrap .zp-gradient { width: 100%; height: 160px; border-radius: 10px; position: relative; overflow: hidden; cursor: crosshair; border: 1px solid rgba(0,0,0,0.08); }
    .xushi-picker-wrap .zp-grad-bg { position: absolute; inset: 0; }
    .xushi-picker-wrap .zp-grad-white { position: absolute; inset: 0; background: linear-gradient(to right, #fff, transparent); }
    .xushi-picker-wrap .zp-grad-black { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, #000); }
    .xushi-picker-wrap .zp-handle { position: absolute; width: 14px; height: 14px; border: 2px solid #fff; border-radius: 50%; box-shadow: 0 0 0 1px rgba(0,0,0,0.3), 0 1px 4px rgba(0,0,0,0.3); transform: translate(-50%, -50%); pointer-events: none; z-index: 10; }
    .xushi-picker-wrap .zp-slider { height: 14px; border-radius: 7px; position: relative; cursor: pointer; border: 1px solid rgba(0,0,0,0.08); overflow: visible; }
    .xushi-picker-wrap .zp-hue { background: linear-gradient(to right, #ff0000 0%, #ffff00 16.66%, #00ff00 33.33%, #00ffff 50%, #0000ff 66.66%, #ff00ff 83.33%, #ff0000 100%); }
    .xushi-picker-wrap .zp-opacity { position: relative; overflow: hidden; }
    .xushi-picker-wrap .zp-opacity-grad { position: absolute; inset: 0; border-radius: 7px; }
    .xushi-picker-wrap .zp-slider-handle { position: absolute; width: 14px; height: 14px; border: 2.5px solid #fff; border-radius: 50%; box-shadow: 0 0 0 0.5px rgba(0,0,0,0.25), 0 1px 3px rgba(0,0,0,0.3); top: 50%; transform: translate(-50%, -50%); pointer-events: none; z-index: 10; }
    .xushi-picker-wrap .zp-footer { display: flex; align-items: center; gap: 8px; margin-top: 2px; }
    .xushi-picker-wrap .zp-format-btn { padding: 6px 10px; border-radius: 8px; border: 1px solid var(--zp-border); font-size: 12px; font-weight: 600; cursor: pointer; background: transparent; color: var(--zp-fg); min-width: 44px; text-align: center; }
    .xushi-picker-wrap .zp-format-btn:hover { background: var(--zp-hover); }
    .xushi-picker-wrap .zp-format-dd { position: absolute; bottom: calc(100% + 6px); left: 0; background: var(--zp-bg); border: 1px solid var(--zp-border); border-radius: 10px; box-shadow: var(--zp-shadow); padding: 6px; display: flex; flex-direction: column; gap: 2px; min-width: 80px; z-index: 100; }
    .xushi-picker-wrap .zp-format-dd div { padding: 6px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; color: var(--zp-fg); }
    .xushi-picker-wrap .zp-format-dd div:hover { background: var(--zp-hover); }
    .xushi-picker-wrap .zp-input-wrap { flex: 1; display: flex; align-items: center; position: relative; }
    .xushi-picker-wrap .zp-input { width: 100%; padding: 6px 30px 6px 10px; border-radius: 8px; border: 1px solid var(--zp-input-border); font-size: 13px; font-family: 'SF Mono', Monaco, monospace; outline: none; background: var(--zp-input-bg); color: var(--zp-fg); transition: border-color 0.15s; }
    .xushi-picker-wrap .zp-input:focus { border-color: #3b82f6; }
    .xushi-picker-wrap .zp-copy { position: absolute; right: 4px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 4px; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--zp-muted); }
    .xushi-picker-wrap .zp-copy:hover { color: var(--zp-fg); background: var(--zp-hover); }
    .xushi-picker-wrap .zp-ok { width: 32px; height: 32px; border-radius: 50%; border: none; background: #22c55e; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.1s, background 0.15s; flex-shrink: 0; }
    .xushi-picker-wrap .zp-ok:hover { background: #16a34a; transform: scale(1.05); }
    .xushi-picker-wrap .zp-ok:active { transform: scale(0.95); }
    .xushi-picker-wrap .zp-checker { background-color: #fff; background-image: linear-gradient(45deg, #ddd 25%, transparent 25%), linear-gradient(-45deg, #ddd 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #ddd 75%), linear-gradient(-45deg, transparent 75%, #ddd 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px; }
  </style>
  @endonce

  <div class="zp-card" id="{{ $pid }}_card">
    <div class="zp-header">
      <div class="zp-tabs">
        <button class="zp-tab active" data-tab="palette" onclick="XushiPicker.switchTab('{{ $pid }}', 'palette')">Palette</button>
        <button class="zp-tab" data-tab="custom" onclick="XushiPicker.switchTab('{{ $pid }}', 'custom')">Custom</button>
      </div>
      <div class="zp-preview zp-checker">
        <div class="zp-preview" id="{{ $pid }}_preview" style="position:absolute;inset:0;border:none;border-radius:6px;"></div>
      </div>
    </div>

    <div class="zp-view" id="{{ $pid }}_paletteView">
      <div class="zp-palette" id="{{ $pid }}_paletteGrid">
        @forelse($defaultSwatches as $color)
          <div class="zp-swatch" style="background:{{ $color }}" onclick="XushiPicker.pick('{{ $pid }}','{{ $color }}')"></div>
        @empty
          <div style="grid-column:1/-1;color:var(--zp-muted);font-size:12px;text-align:center;padding:8px;">No swatches</div>
        @endforelse
        <button class="zp-expand" onclick="XushiPicker.expand('{{ $pid }}', true)" title="Expand">+</button>
      </div>
      <div class="zp-palette-big zp-hidden" id="{{ $pid }}_paletteBig">
        @forelse($expandedSwatches as $color)
          <div class="zp-swatch" style="background:{{ $color }};border-radius:6px" onclick="XushiPicker.pick('{{ $pid }}','{{ $color }}')"></div>
        @empty
          <div style="grid-column:1/-1;color:var(--zp-muted);font-size:12px;text-align:center;padding:8px;">No swatches</div>
        @endforelse
        <button class="zp-expand" onclick="XushiPicker.expand('{{ $pid }}', false)" title="Collapse">−</button>
      </div>
    </div>

    <div class="zp-view zp-hidden" id="{{ $pid }}_customView">
      <div class="zp-gradient" id="{{ $pid }}_gradBox">
        <div class="zp-grad-bg" id="{{ $pid }}_gradBg"></div>
        <div class="zp-grad-white"></div>
        <div class="zp-grad-black"></div>
        <div class="zp-handle" id="{{ $pid }}_gradHandle"></div>
      </div>
      <div><div class="zp-slider zp-hue" id="{{ $pid }}_hue"><div class="zp-slider-handle" id="{{ $pid }}_hueHandle"></div></div></div>
      @if($isAlpha)
      <div><div class="zp-slider zp-opacity zp-checker" id="{{ $pid }}_opacity"><div class="zp-opacity-grad" id="{{ $pid }}_opacityGrad"></div><div class="zp-slider-handle" id="{{ $pid }}_opacityHandle"></div></div></div>
      @endif
    </div>

    <div class="zp-footer">
      <div style="position:relative;">
        <button class="zp-format-btn" onclick="XushiPicker.toggleFormat('{{ $pid }}')" id="{{ $pid }}_fmtBtn">{{ strtoupper($compFormat) }}</button>
        <div class="zp-format-dd zp-hidden" id="{{ $pid }}_fmtDd">
          <div onclick="XushiPicker.setFormat('{{ $pid }}','hex')">HEX</div>
          <div onclick="XushiPicker.setFormat('{{ $pid }}','rgb')">RGB</div>
          <div onclick="XushiPicker.setFormat('{{ $pid }}','hsl')">HSL</div>
          <div onclick="XushiPicker.setFormat('{{ $pid }}','oklch')">OKLCH</div>
        </div>
      </div>
      <div class="zp-input-wrap">
        <input type="text" class="zp-input" id="{{ $pid }}_input" value="{{ $initial }}" spellcheck="false" onchange="XushiPicker.fromInput('{{ $pid }}')">
        <button class="zp-copy" onclick="XushiPicker.copy('{{ $pid }}')" title="Copy">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </button>
      </div>
      @if($isClear)
      <button class="zp-ok" style="background:#ef4446" onclick="XushiPicker.clear('{{ $pid }}')" title="Clear">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
      @endif
      <button class="zp-ok" onclick="XushiPicker.confirm('{{ $pid }}')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
      </button>
    </div>
  </div>

  @once
  <script>
  (function(){
    if (!window.XushiPicker) {
      window.XushiPicker = {};
    }

    if (window.XushiPicker.create) {
      return;
    }

    window.XushiPicker.create = function(config) {
    const pid = config.pid;

    const st = window.XushiPicker[pid] = {
      h: 0.92, s: 1.0, v: 1.0, a: 1.0,
      format: config.format,
      tab: 'palette',
      expanded: false,
      alpha: config.alpha,
      name: config.name
    };

    function rgbFromHsv(h,s,v){let r,g,b;const i=Math.floor(h*6),f=h*6-i,p=v*(1-s),q=v*(1-f*s),t=v*(1-(1-f)*s);switch(i%6){case 0:r=v;g=t;b=p;break;case 1:r=q;g=v;b=p;break;case 2:r=p;g=v;b=t;break;case 3:r=p;g=q;b=v;break;case 4:r=t;g=p;b=v;break;case 5:r=v;g=p;b=q;}return{r:Math.round(r*255),g:Math.round(g*255),b:Math.round(b*255)};}
    function hsvFromRgb(r,g,b){r/=255;g/=255;b/=255;const max=Math.max(r,g,b),min=Math.min(r,g,b);let h,s,v=max;const d=max-min;s=max===0?0:d/max;if(max===min)h=0;else{switch(max){case r:h=(g-b)/d+(g<b?6:0);break;case g:h=(b-r)/d+2;break;case b:h=(r-g)/d+4;break;}h/=6;}return{h,s,v};}
    function hexFromRgb(r,g,b){return'#'+[r,g,b].map(x=>{const h=Math.max(0,Math.min(255,x)).toString(16);return h.length===1?'0'+h:h;}).join('');}
    function rgbFromHex(hex){const m=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);return m?{r:parseInt(m[1],16),g:parseInt(m[2],16),b:parseInt(m[3],16)}:null;}
    function hslFromRgb(r,g,b){r/=255;g/=255;b/=255;const max=Math.max(r,g,b),min=Math.min(r,g,b);let h,s,l=(max+min)/2;if(max===min){h=s=0;}else{const d=max-min;s=l>0.5?d/(2-max-min):d/(max+min);switch(max){case r:h=(g-b)/d+(g<b?6:0);break;case g:h=(b-r)/d+2;break;case b:h=(r-g)/d+4;break;}h/=6;}return{h:Math.round(h*360),s:Math.round(s*100),l:Math.round(l*100)};}
    function oklchFromRgb(r,g,b){const hsl=hslFromRgb(r,g,b);return{l:Math.round((hsl.l/100)*100),c:Math.round(hsl.s*0.4),h:hsl.h};}
    function hexFromHsl(h,s,l){l/=100;const a=s*Math.min(l,1-l)/100;const f=n=>{const k=(n+h/30)%12;const c=l-a*Math.max(Math.min(k-3,9-k,1),-1);return Math.round(255*c).toString(16).padStart(2,'0');};return`#${f(0)}${f(8)}${f(4)}`;}

    function update(){
      const rgb=rgbFromHsv(st.h,st.s,st.v);
      const hex=hexFromRgb(rgb.r,rgb.g,rgb.b);
      const rgba=`rgba(${rgb.r},${rgb.g},${rgb.b},${st.a.toFixed(2)})`;
      const prev=document.getElementById(pid+'_preview');
      if(prev) prev.style.background=rgba;
      const pure=rgbFromHsv(st.h,1,1);
      const gradBg=document.getElementById(pid+'_gradBg');
      if(gradBg) gradBg.style.background=`rgb(${pure.r},${pure.g},${pure.b})`;
      const gh=document.getElementById(pid+'_gradHandle');
      if(gh){gh.style.left=(st.s*100)+'%';gh.style.top=((1-st.v)*100)+'%';}
      const hh=document.getElementById(pid+'_hueHandle');
      if(hh) hh.style.left=(st.h*100)+'%';
      if(st.alpha){const oh=document.getElementById(pid+'_opacityHandle');if(oh)oh.style.left=(st.a*100)+'%';const og=document.getElementById(pid+'_opacityGrad');if(og)og.style.background=`linear-gradient(to right,transparent,rgb(${rgb.r},${rgb.g},${rgb.b}))`;}
      const inp=document.getElementById(pid+'_input');
      if(!inp) return;
      if(st.format==='hex') inp.value=hex;
      else if(st.format==='rgb') inp.value=`rgb(${rgb.r},${rgb.g},${rgb.b})`;
      else if(st.format==='hsl'){const hsl=hslFromRgb(rgb.r,rgb.g,rgb.b);inp.value=`hsl(${hsl.h},${hsl.s}%,${hsl.l}%)`;}
      else if(st.format==='oklch'){const o=oklchFromRgb(rgb.r,rgb.g,rgb.b);inp.value=`oklch(${o.l}% ${o.c} ${o.h})`;}
      const hidden=document.getElementById(pid+'_value'); if(hidden) hidden.value=hex;
    }

    function initFromHex(hex){const rgb=rgbFromHex(hex);if(!rgb)return;const hsv=hsvFromRgb(rgb.r,rgb.g,rgb.b);st.h=hsv.h;st.s=hsv.s;st.v=hsv.v;st.a=1;update();}

    st.switchTab=function(tab){st.tab=tab;const el=document.getElementById(pid);if(!el)return;el.querySelectorAll('.zp-tab').forEach(t=>t.classList.toggle('active',t.dataset.tab===tab));const pv=document.getElementById(pid+'_paletteView');if(pv)pv.classList.toggle('zp-hidden',tab!=='palette');const cv=document.getElementById(pid+'_customView');if(cv)cv.classList.toggle('zp-hidden',tab!=='custom');if(tab==='custom'&&st.expanded)st.expand(false);};
    st.expand=function(exp){st.expanded=exp;const card=document.getElementById(pid+'_card');if(card)card.classList.toggle('expanded',exp);const pg=document.getElementById(pid+'_paletteGrid');if(pg)pg.classList.toggle('zp-hidden',exp);const pb=document.getElementById(pid+'_paletteBig');if(pb)pb.classList.toggle('zp-hidden',!exp);};
    st.pick=function(hex){initFromHex(hex);st.a=1;update();};
    st.toggleFormat=function(){const dd=document.getElementById(pid+'_fmtDd');if(dd)dd.classList.toggle('zp-hidden');};
    st.setFormat=function(fmt){st.format=fmt;const btn=document.getElementById(pid+'_fmtBtn');if(btn)btn.textContent=fmt.toUpperCase();const dd=document.getElementById(pid+'_fmtDd');if(dd)dd.classList.add('zp-hidden');update();};
    st.copy=function(){const v=document.getElementById(pid+'_input');if(!v)return;navigator.clipboard.writeText(v.value).then(()=>{let t=document.getElementById('zp_toast');if(!t){t=document.createElement('div');t.id='zp_toast';t.style.cssText='position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(100px);background:#222;color:#fff;padding:10px 20px;border-radius:10px;font-size:13px;opacity:0;transition:all 0.3s;z-index:var(--xushi-z-toast);pointer-events:none;';document.body.appendChild(t);}t.textContent='Copied!';t.style.opacity='1';t.style.transform='translateX(-50%) translateY(0)';setTimeout(()=>{t.style.opacity='0';t.style.transform='translateX(-50%) translateY(100px)';},2000);});};
    st.confirm=function(){const v=document.getElementById(pid+'_input');if(!v)return;const el=document.getElementById(pid);el.dispatchEvent(new CustomEvent('xushi-pick',{detail:{value:v.value,name:st.name},bubbles:true}));};
    st.clear=function(){const inp=document.getElementById(pid+'_input');if(inp)inp.value='';const prev=document.getElementById(pid+'_preview');if(prev)prev.style.background='transparent';};
    st.fromInput=function(){const v=document.getElementById(pid+'_input');if(!v)return;const rgb=rgbFromHex(v.value.trim());if(rgb){initFromHex(v.value.trim());}};

    window.XushiPicker.switchTab=function(id,tab){window.XushiPicker[id]?.switchTab(tab);};
    window.XushiPicker.expand=function(id,exp){window.XushiPicker[id]?.expand(exp);};
    window.XushiPicker.pick=function(id,hex){window.XushiPicker[id]?.pick(hex);};
    window.XushiPicker.toggleFormat=function(id){window.XushiPicker[id]?.toggleFormat();};
    window.XushiPicker.setFormat=function(id,fmt){window.XushiPicker[id]?.setFormat(fmt);};
    window.XushiPicker.copy=function(id){window.XushiPicker[id]?.copy();};
    window.XushiPicker.confirm=function(id){window.XushiPicker[id]?.confirm();};
    window.XushiPicker.clear=function(id){window.XushiPicker[id]?.clear();};
    window.XushiPicker.fromInput=function(id){window.XushiPicker[id]?.fromInput();};

    function setupDrag(elId,upFn){const el=document.getElementById(elId);if(!el)return;let drag=false;el.addEventListener('mousedown',e=>{drag=true;upFn(e);});el.addEventListener('touchstart',e=>{drag=true;upFn(e.touches[0]);e.preventDefault();},{passive:false});const mv=e=>{if(!drag)return;const c=e.touches?e.touches[0]:e;upFn(c);if(e.touches)e.preventDefault();};document.addEventListener('mousemove',mv);document.addEventListener('touchmove',mv,{passive:false});document.addEventListener('mouseup',()=>drag=false);document.addEventListener('touchend',()=>drag=false);}

    setupDrag(pid+'_gradBox',e=>{const r=document.getElementById(pid+'_gradBox');if(!r)return;const rect=r.getBoundingClientRect();st.s=Math.max(0,Math.min(1,(e.clientX-rect.left)/rect.width));st.v=Math.max(0,Math.min(1,1-(e.clientY-rect.top)/rect.height));update();});
    setupDrag(pid+'_hue',e=>{const r=document.getElementById(pid+'_hue');if(!r)return;const rect=r.getBoundingClientRect();st.h=Math.max(0,Math.min(1,(e.clientX-rect.left)/rect.width));update();});
    if(st.alpha){setupDrag(pid+'_opacity',e=>{const r=document.getElementById(pid+'_opacity');if(!r)return;const rect=r.getBoundingClientRect();st.a=Math.max(0,Math.min(1,(e.clientX-rect.left)/rect.width));update();});}

    document.addEventListener('click',e=>{if(!e.target.closest('#'+pid+' .zp-format-btn')&&!e.target.closest('#'+pid+'_fmtDd')){const dd=document.getElementById(pid+'_fmtDd');if(dd)dd.classList.add('zp-hidden');}});

    initFromHex(config.initial);
    };
  })();
  </script>
  @endonce

  <script>
    window.XushiPicker.create({
      pid: @json($pid),
      format: @json($compFormat),
      alpha: @json($isAlpha),
      name: @json($compName),
      initial: @json($initial),
    });
  </script>

  @if($compName)
  <input type="hidden" name="{{ $compName }}" id="{{ $pid }}_value" value="{{ $initial }}">
  @endif
</div>
