<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Source directory
    |--------------------------------------------------------------------------
    | Directory containing the source PNG/JPG images to process, relative to
    | the project root.
    */
    'source' => 'assets/static/images',

    /*
    |--------------------------------------------------------------------------
    | Destination directory
    |--------------------------------------------------------------------------
    | Directory where the optimized AVIF, WebP and JPG files will be saved,
    | relative to the project root.
    */
    'destination' => 'public/img',

    /*
    |--------------------------------------------------------------------------
    | Output quality
    |--------------------------------------------------------------------------
    | Compression quality per format, from 1 (smallest) to 100 (best quality).
    */
    'quality' => [
        'avif' => 60,
        'webp' => 82,
        'jpg' => 85,
    ],

    /*
    |--------------------------------------------------------------------------
    | Output formats
    |--------------------------------------------------------------------------
    | List of image formats to generate.
    |
    | Allowed values: avif, webp, jpg
    */
    'formats' => ['avif', 'webp', 'jpg'],

    /*
    |--------------------------------------------------------------------------
    | HiDPI densities
    |--------------------------------------------------------------------------
    | List of pixel density multipliers to generate for each width.
    | 1 is always the base variant (e.g. image-200.avif).
    | Add 2 for @2x, 3 for @3x, etc.
    |
    | Example: [1, 2, 3] generates image-200.avif, image-200@2x.avif, image-200@3x.avif
    */
    'densities' => [1, 2],

    /*
    |--------------------------------------------------------------------------
    | Folder configuration
    |--------------------------------------------------------------------------
    | For each subfolder in the source directory, define the target widths in
    | pixels. AVIF, WebP and JPG will be generated for each width, plus a @2x
    | variant for HiDPI screens.
    |
    | Set widths to null to convert and optimize without resizing.
    | Subfolders not listed here are simply converted without resizing.
    |
    | Usage example: asset('img/product/hero-200.avif')
    |                asset('img/product/hero-200@2x.avif')
    */
    'folders' => [
        'logo_partners' => [630, 300, 170, 100],
        'bg' => [2000, 1400, 992, 768, 576, 300],
        'guide' => [800, 620, 530, 400],
        'main' => [400, 200],
    ],
];
