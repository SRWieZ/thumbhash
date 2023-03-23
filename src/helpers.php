<?php

namespace Thumbhash;

use Imagick;

function extract_size_and_pixels_with_gd($content): array
{
    $image = imagecreatefromstring($content);

    $width = imagesx($image);
    $height = imagesy($image);

    $pixels = [];
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $color_index = imagecolorat($image, $x, $y);
            $color = imagecolorsforindex($image, $color_index);
            $alpha = 255 - ceil($color['alpha'] * (255 / 127)); // GD only supports 7-bit alpha channel
            $pixels[] = $color['red'];
            $pixels[] = $color['green'];
            $pixels[] = $color['blue'];
            $pixels[] = $alpha;
        }
    }
    // $size = max($width, $height);
    // $width = round(100 * $width / $size);
    // $height = round(100 * $height / $size);

    return [$width, $height, $pixels];
}

/**
 * @throws \ImagickException
 * @throws \ImagickPixelException
 */
function extract_size_and_pixels_with_imagick($content): array
{
    $image = new Imagick();
    $image->readImageBlob($content);

    $width = $image->getImageWidth();
    $height = $image->getImageHeight();

    $pixels = [];
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {

            $pixel = $image->getImagePixelColor($x, $y);
            $colors = $pixel->getColor(2);
            $pixels[] = $colors['r'];
            $pixels[] = $colors['g'];
            $pixels[] = $colors['b'];
            $pixels[] = $colors['a'];
        }
    }
    return [$width, $height, $pixels];
}

