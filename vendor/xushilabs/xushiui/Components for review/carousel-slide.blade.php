@props([])

<div
    class="xushi-carousel-slide"
    style="
        flex: 0 0 100%;
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    "
    {{ $attributes }}
>
    {{ $slot }}
</div>
