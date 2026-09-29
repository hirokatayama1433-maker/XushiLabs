@props([])

@once
    <style>
            .xushi-header-nav {
            display: inline-flex;
            align-items: center;
             }   
        </style>
@endonce
<nav style="display:flex; align-items:center; gap:0.25rem;" {{ $attributes }}>
    {{ $slot }}
</nav>