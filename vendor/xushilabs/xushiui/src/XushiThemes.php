<?php

namespace Xushi\UI;

class XushiThemes
{
    /**
     * Base palettes — 6 palettes × 2 modes = 12 entries.
     * Tokens: background, foreground, neutral, content, content-subtle
     */
    public static array $bases = [
        'neutral-light' => [
            '--xushi-color-base-background'     => 'oklch(0.9700 0 0)',
            '--xushi-color-base-foreground'     => 'oklch(0.9900 0 0)',
            '--xushi-color-base-neutral'        => 'oklch(0.9000 0 0)',
            '--xushi-color-base-content'        => 'oklch(0.2000 0 0)',
            '--xushi-color-base-content-subtle' => 'oklch(0.5200 0 0)',
            '--xushi-color-sidebar'             => 'oklch(0.9800 0 0)',
            '--xushi-color-header'              => 'oklch(0.9700 0 0)',
        ],

        'neutral-dark' => [
            '--xushi-color-base-background'     => 'oklch(0.1700 0 0)',
            '--xushi-color-base-foreground'     => 'oklch(0.2000 0 0)',
            '--xushi-color-base-neutral'        => 'oklch(0.2500 0 0)',
            '--xushi-color-base-content'        => 'oklch(0.9200 0 0)',
            '--xushi-color-base-content-subtle' => 'oklch(0.7200 0 0)',
            '--xushi-color-sidebar'             => 'oklch(0.1600 0 0)',
            '--xushi-color-header'              => 'oklch(0.1800 0 0)',
        ],
        'warm-light' => [
            '--xushi-color-base-background'    => 'oklch(98% 0.006 80)',
            '--xushi-color-base-foreground'    => 'oklch(100% 0 0)',
            '--xushi-color-base-neutral'       => 'oklch(94% 0.008 80)',
            '--xushi-color-base-content'       => 'oklch(22% 0.01 80)',
            '--xushi-color-base-content-subtle'=> 'oklch(52% 0.008 80)',
        ],
        'warm-dark' => [
            '--xushi-color-base-background'    => 'oklch(14% 0.008 80)',
            '--xushi-color-base-foreground'    => 'oklch(18% 0.008 80)',
            '--xushi-color-base-neutral'       => 'oklch(24% 0.012 80)',
            '--xushi-color-base-content'       => 'oklch(92% 0.006 80)',
            '--xushi-color-base-content-subtle'=> 'oklch(62% 0.008 80)',
        ],
        'cool-light' => [
            '--xushi-color-base-background'    => 'oklch(98% 0.006 240)',
            '--xushi-color-base-foreground'    => 'oklch(100% 0 0)',
            '--xushi-color-base-neutral'       => 'oklch(94% 0.008 240)',
            '--xushi-color-base-content'       => 'oklch(22% 0.01 240)',
            '--xushi-color-base-content-subtle'=> 'oklch(52% 0.008 240)',
        ],
        'cool-dark' => [
            '--xushi-color-base-background'    => 'oklch(14% 0.008 240)',
            '--xushi-color-base-foreground'    => 'oklch(18% 0.008 240)',
            '--xushi-color-base-neutral'       => 'oklch(24% 0.012 240)',
            '--xushi-color-base-content'       => 'oklch(92% 0.006 240)',
            '--xushi-color-base-content-subtle'=> 'oklch(62% 0.008 240)',
        ],
        'rose-light' => [
            '--xushi-color-base-background'    => 'oklch(98% 0.006 10)',
            '--xushi-color-base-foreground'    => 'oklch(100% 0 0)',
            '--xushi-color-base-neutral'       => 'oklch(94% 0.008 10)',
            '--xushi-color-base-content'       => 'oklch(22% 0.01 10)',
            '--xushi-color-base-content-subtle'=> 'oklch(52% 0.008 10)',
        ],
        'rose-dark' => [
            '--xushi-color-base-background'    => 'oklch(14% 0.008 10)',
            '--xushi-color-base-foreground'    => 'oklch(18% 0.008 10)',
            '--xushi-color-base-neutral'       => 'oklch(24% 0.012 10)',
            '--xushi-color-base-content'       => 'oklch(92% 0.006 10)',
            '--xushi-color-base-content-subtle'=> 'oklch(62% 0.008 10)',
        ],
        'forest-light' => [
            '--xushi-color-base-background'    => 'oklch(98% 0.006 145)',
            '--xushi-color-base-foreground'    => 'oklch(100% 0 0)',
            '--xushi-color-base-neutral'       => 'oklch(94% 0.008 145)',
            '--xushi-color-base-content'       => 'oklch(22% 0.01 145)',
            '--xushi-color-base-content-subtle'=> 'oklch(52% 0.008 145)',
        ],
        'forest-dark' => [
            '--xushi-color-base-background'    => 'oklch(14% 0.008 145)',
            '--xushi-color-base-foreground'    => 'oklch(18% 0.008 145)',
            '--xushi-color-base-neutral'       => 'oklch(24% 0.012 145)',
            '--xushi-color-base-content'       => 'oklch(92% 0.006 145)',
            '--xushi-color-base-content-subtle'=> 'oklch(62% 0.008 145)',
        ],
        'slate-light' => [
            '--xushi-color-base-background'    => 'oklch(98% 0.005 220)',
            '--xushi-color-base-foreground'    => 'oklch(100% 0 0)',
            '--xushi-color-base-neutral'       => 'oklch(93% 0.007 220)',
            '--xushi-color-base-content'       => 'oklch(22% 0.012 220)',
            '--xushi-color-base-content-subtle'=> 'oklch(52% 0.008 220)',
        ],
        'slate-dark' => [
            '--xushi-color-base-background'    => 'oklch(14% 0.009 220)',
            '--xushi-color-base-foreground'    => 'oklch(18% 0.009 220)',
            '--xushi-color-base-neutral'       => 'oklch(24% 0.013 220)',
            '--xushi-color-base-content'       => 'oklch(92% 0.006 220)',
            '--xushi-color-base-content-subtle'=> 'oklch(62% 0.008 220)',
        ],
    ];

    /**
     * Accent palettes — 14 entries.
     * Tokens: primary, primary-content, secondary, secondary-content
     */
    public static array $accents = [
        'neutral' => [
            '--xushi-color-primary'           => 'oklch(30% 0.006 264)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.002 264)',
            '--xushi-color-secondary'         => 'oklch(55% 0.006 264)',
            '--xushi-color-secondary-content' => 'oklch(97% 0.002 264)',
        ],
        'blue' => [
            '--xushi-color-primary'           => 'oklch(52% 0.22 250)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 250)',
            '--xushi-color-secondary'         => 'oklch(68% 0.15 250)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 250)',
        ],
        'indigo' => [
            '--xushi-color-primary'           => 'oklch(50% 0.23 280)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 280)',
            '--xushi-color-secondary'         => 'oklch(65% 0.16 280)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 280)',
        ],
        'violet' => [
            '--xushi-color-primary'           => 'oklch(52% 0.23 305)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 305)',
            '--xushi-color-secondary'         => 'oklch(68% 0.16 305)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 305)',
        ],
        'pink' => [
            '--xushi-color-primary'           => 'oklch(58% 0.22 345)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 345)',
            '--xushi-color-secondary'         => 'oklch(72% 0.15 345)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 345)',
        ],
        'rose' => [
            '--xushi-color-primary'           => 'oklch(55% 0.22 15)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 15)',
            '--xushi-color-secondary'         => 'oklch(70% 0.15 15)',  
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 15)',
        ],
        'orange' => [
            '--xushi-color-primary'           => 'oklch(65% 0.2 50)',
            '--xushi-color-primary-content'   => 'oklch(15% 0.03 50)',
            '--xushi-color-secondary'         => 'oklch(78% 0.14 50)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 50)',
        ],
        'amber' => [
            '--xushi-color-primary'           => 'oklch(72% 0.17 75)',
            '--xushi-color-primary-content'   => 'oklch(15% 0.03 75)',
            '--xushi-color-secondary'         => 'oklch(82% 0.12 75)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 75)',
        ],
        'yellow' => [
            '--xushi-color-primary'           => 'oklch(82% 0.16 98)',
            '--xushi-color-primary-content'   => 'oklch(15% 0.03 98)',
            '--xushi-color-secondary'         => 'oklch(88% 0.1 98)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 98)',
        ],
        'lime' => [
            '--xushi-color-primary'           => 'oklch(72% 0.2 128)',
            '--xushi-color-primary-content'   => 'oklch(15% 0.03 128)',
            '--xushi-color-secondary'         => 'oklch(82% 0.14 128)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 128)',
        ],
        'green' => [
            '--xushi-color-primary'           => 'oklch(55% 0.17 145)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 145)',
            '--xushi-color-secondary'         => 'oklch(70% 0.13 145)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 145)',
        ],
        'teal' => [
            '--xushi-color-primary'           => 'oklch(57% 0.17 180)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 180)',
            '--xushi-color-secondary'         => 'oklch(72% 0.13 180)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 180)',
        ],
        'cyan' => [
            '--xushi-color-primary'           => 'oklch(62% 0.18 205)',
            '--xushi-color-primary-content'   => 'oklch(15% 0.03 205)',
            '--xushi-color-secondary'         => 'oklch(75% 0.13 205)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 205)',
        ],
        'sky' => [
            '--xushi-color-primary'           => 'oklch(60% 0.2 230)',
            '--xushi-color-primary-content'   => 'oklch(97% 0.01 230)',
            '--xushi-color-secondary'         => 'oklch(74% 0.14 230)',
            '--xushi-color-secondary-content' => 'oklch(15% 0.03 230)',
        ],
    ];

    /**
     * Layout variants — 3 entries.
     * Tokens: container-radius, container-padding, container-gap,
     *         control-radius, control-padding, shadow
     */
    public static array $layouts = [
        'rounded' => [
            '--xushi-container-radius'  => '1rem',
            '--xushi-container-padding' => '1.5rem',
            '--xushi-container-gap'     => '1.25rem',
            '--xushi-control-radius'    => '0.75rem',
            '--xushi-control-padding'   => '0.625rem 1rem',
            '--xushi-shadow'            => '0 4px 24px oklch(0% 0 0 / 0.08)',
        ],
        'default' => [
            '--xushi-container-radius'  => '0.5rem',
            '--xushi-container-padding' => '1.25rem',
            '--xushi-container-gap'     => '1rem',
            '--xushi-control-radius'    => '0.375rem',
            '--xushi-control-padding'   => '0.5rem 0.875rem',
            '--xushi-shadow'            => '0 2px 12px oklch(0% 0 0 / 0.07)',
        ],
        'sharp' => [
            '--xushi-container-radius'  => '0.25rem',
            '--xushi-container-padding' => '1rem',
            '--xushi-container-gap'     => '0.75rem',
            '--xushi-control-radius'    => '0.125rem',
            '--xushi-control-padding'   => '0.5rem 0.75rem',
            '--xushi-shadow'            => '0 1px 6px oklch(0% 0 0 / 0.06)',
        ],
    ];
}