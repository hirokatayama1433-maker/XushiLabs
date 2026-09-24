@props([
    'variant' => 'solid',
    'striped' => false,
    'radius' => 'var(--xushi-radius-box)',
    'shadow' => null,
    'margin' => null,
    'border' => 'var(--xushi-border-box)',
    'bordercolor' => 'var(--xushi-color-base-border)',
])

@once
<style>
    .xushi-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .xushi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        color: var(--xushi-color-base-content);
    }

    .xushi-table-head {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--xushi-color-base-content);
        opacity: 0.6;
        text-align: left;
        padding: 0.625rem 0.75rem;
        border-bottom: var(--xushi-border-box) solid var(--xushi-color-base-border);
        white-space: nowrap;
        user-select: none;
    }

    .xushi-table-head-inner {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .xushi-table-head[x-data] {
        cursor: pointer;
    }

    .xushi-table-head[x-data]:hover {
        opacity: 1;
        color: var(--xushi-color-primary);
    }

    .xushi-table-sort-icon {
        width: 0.875rem;
        height: 0.875rem;
        opacity: 0.4;
        transition: opacity 150ms ease, transform 150ms ease;
    }

    .xushi-table-sort-icon[data-direction="asc"] {
        opacity: 1;
        transform: rotate(0deg);
    }

    .xushi-table-sort-icon[data-direction="desc"] {
        opacity: 1;
        transform: rotate(180deg);
    }

    .xushi-table-tbody tr {
        border-bottom: var(--xushi-border-box) solid var(--xushi-color-base-border);
        transition: background 100ms ease;
    }

    .xushi-table-tbody tr:hover {
        background: color-mix(in oklch, var(--xushi-color-base-content) 4%, transparent);
    }

    .xushi-table-tbody tr:last-child .xushi-table-cell {
        border-bottom: none;
    }

    .xushi-table--striped tbody tr:nth-child(even) {
        background: color-mix(in oklch, var(--xushi-color-base-content) 3%, transparent);
    }

    .xushi-table--striped tbody tr:nth-child(even):hover {
        background: color-mix(in oklch, var(--xushi-color-base-content) 6%, transparent);
    }
</style>
@endonce

@php
    $variantStyles = [
        'solid' => ['background' => 'var(--xushi-color-base-100)', 'color' => 'var(--xushi-color-base-content)'],
        'soft' => ['background' => 'var(--xushi-color-base-200)', 'color' => 'var(--xushi-color-base-content)'],
    ];

    $resolved = $variantStyles[$variant] ?? $variantStyles['solid'];
    $style = collect(array_merge([
        'border-radius' => $radius,
        'box-shadow' => $shadow,
        'margin' => $margin,
        'border-width' => $border,
        'border-color' => $bordercolor,
    ], $resolved))->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div class="xushi-table-container">
    <table class="xushi-table {{ $striped ? 'xushi-table--striped' : '' }}" style="{{ $style }}" {{ $attributes }}>
        @isset($header)
            <thead class="xushi-table-thead">
                <tr>{{ $header }}</tr>
            </thead>
        @endisset

        <tbody class="xushi-table-tbody">
            {{ $slot }}
        </tbody>
    </table>
</div>
