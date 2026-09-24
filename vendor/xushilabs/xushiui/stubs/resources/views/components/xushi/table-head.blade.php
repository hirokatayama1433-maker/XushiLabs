@props([
    'style' => null,
    'sort' => null,
])

<th
    class="xushi-table-head"
    style="{{ $style }}"
    @if($sort) x-data="xushiTableSort()" @click="toggle('{{ $attributes->get('name', '') }}')" @endif
    {{ $attributes->except(['name']) }}
>
    <span class="xushi-table-head-inner">
        {{ $slot }}

        @if($sort)
            <span class="xushi-table-sort-icon" data-direction="{{ $sort }}">
                <xushi:icon :name="$sort === 'desc' ? 'chevron-down' : 'chevron-up'" />
            </span>
        @endif
    </span>
</th>
