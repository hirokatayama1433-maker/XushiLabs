<?php

namespace Xushi\UI;

use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

class XushiManager
{
    public function styleString(array $styles): string
    {
        return collect($styles)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->map(fn ($value, $key) => "{$key}: {$value}")
            ->implode('; ');
    }

    public function splitAttributes(ComponentAttributeBag $attributes, array $by = ['class', 'style'], bool $strict = false): array
    {
        return [
            $strict ? $attributes->only($by) : $attributes->whereStartsWith($by),
            $strict ? $attributes->except($by) : $attributes->whereDoesntStartWith($by),
        ];
    }

    public function forwardedAttributes(ComponentAttributeBag $attributes, array $propKeys): array
    {
        $props = [];
        $unescape = fn ($value) => is_string($value) ? htmlspecialchars_decode($value, ENT_QUOTES) : $value;

        foreach ($propKeys as $key) {
            if (isset($attributes[$key])) {
                $props[$key] = $unescape($attributes[$key]);
            } elseif (isset($attributes[Str::kebab($key)])) {
                $props[$key] = $unescape($attributes[Str::kebab($key)]);
            }
        }

        return $props;
    }

    public function attributesAfter(string $prefix, ComponentAttributeBag $attributes, array $default = []): ComponentAttributeBag
    {
        $newAttributes = new ComponentAttributeBag($default);
        $keysToRemove = [];

        foreach ($attributes->getAttributes() as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $newAttributes[substr($key, strlen($prefix))] = $value;
                $keysToRemove[] = $key;
            }
        }

        foreach ($keysToRemove as $key) {
            unset($attributes[$key]);
        }

        return $newAttributes;
    }

    public function renderStyles(): string
    {
        return XushiAssetManager::renderStyles();
    }

    public function renderScripts(): string
    {
        return XushiAssetManager::renderScripts();
    }

    public function renderAppearance(): string
    {
        return XushiAssetManager::renderAppearance();
    }
}
