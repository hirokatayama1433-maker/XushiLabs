@props([
    'margin' => null,
    'marginleft' => null,
    'marginright' => null,
    'margintop' => null,
    'marginbottom' => null,
    'padding' => '10px',
    'width' => '100%',
    'mobileWidth' => '100%',
])

@php 
$uid = 'xushi-main-' . uniqid(); 
@endphp

@once
<style>
    .xushimain {
        grid-area: main;
        scroll-behavior: smooth;
        overflow: auto;
        min-height: 0;
        display: flex;
        justify-content: center;
    }
</style>
@endonce

<style>
    #{{ $uid }}-inner { width: {{ $width }}; height: 100%; }
    @media (max-width: 768px) {
        #{{ $uid }}-inner { width: {{ $mobileWidth }} !important; }
    }
</style>

<div
    class="xushimain"
    style="
        display: flex;
        flex-direction: column;
        justify-content: center     ;
        align-items: center;
        position: relative;
        z-index: var(--xushi-z-shell-base);
        overflow-y: auto;
        overflow-x: hidden;
        {{ $padding      ? 'padding: '       . $padding      . ';' : '' }}
        {{ $margin       ? 'margin: '        . $margin       . ';' : '' }}
        {{ $marginleft   ? 'margin-left: '   . $marginleft   . ';' : '' }}
        {{ $marginright  ? 'margin-right: '  . $marginright  . ';' : '' }}
        {{ $margintop    ? 'margin-top: '    . $margintop    . ';' : '' }}
        {{ $marginbottom ? 'margin-bottom: ' . $marginbottom . ';' : '' }}
    "
    {{ $attributes }}
>
    <div id="{{ $uid }}-inner"
    style="
        display: flex;
        flex-direction: column;">
        {{ $slot }}
        <div style="height: 50px; flex-shrink: 0;"></div>
    </div>
   
</div>
