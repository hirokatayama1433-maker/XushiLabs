@props([
    'label' => '',
    'error' => null,
    'hint' => null,
])

@once
<style>
    .xushi-fieldset {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        width: 100%;
    }

    .xushi-fieldset-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--xushi-color-base-content);
    }

    .xushi-fieldset-body {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .xushi-fieldset-hint {
        font-size: 0.75rem;
        color: var(--xushi-color-base-content);
        opacity: 0.6;
    }

    .xushi-fieldset-error {
        font-size: 0.75rem;
        color: var(--xushi-color-danger);
    }
</style>
@endonce

{{-- existing blade HTML below --}}
<fieldset class="xushi-fieldset" {{ $attributes->except(['class', 'style']) }}>
    @if($label !== '')
        <legend class="xushi-fieldset-label">{{ $label }}</legend>
    @endif

    <div class="xushi-fieldset-body">
        {{ $slot }}
    </div>

    @if($hint)
        <div class="xushi-fieldset-hint">{{ $hint }}</div>
    @endif

    @if($error)
        <div class="xushi-fieldset-error">{{ $error }}</div>
    @endif
</fieldset>
