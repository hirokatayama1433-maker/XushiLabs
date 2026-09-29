@props([
    'style' => null,
])

<td class="xushi-table-cell" style="{{ $style }}" {{ $attributes }}>
    {{ $slot }}
</td>
