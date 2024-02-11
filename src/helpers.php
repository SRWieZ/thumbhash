<?php

namespace Thumbhash;

use Imagick;

/**
 * Extract image data using the GD extension.
 *
 * GD only provides 127-bit alpha data, so this up-scales it to 255 bits.
 *
 * @param  string  $content  The binary data of the image to be processed.
 * @return array An array containing the width, height, and pixel data of the image.
 * @throws \Exception
 */
function extract_size_and_pixels_with_gd($content): array
{
    $image = imagecreatefromstring($content);

    if ($image === false) {
        throw new \Exception("Unable to read data, make sure that the appropriate " .
            "image type support is enabled in GD.");
    }

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

/**
 *
 * Extracts the size (width and height) and pixel data (RGBA) from an image using the Imagick library
 * and ImagickPixelIterator.
 * @param  string  $content  The binary data of the image to be processed.
 * @return array An array containing the width, height, and pixel data of the image.
 * @throws \ImagickPixelIteratorException
 */
function extract_size_and_pixels_with_imagick_pixel_iterator($content): array
{
    // Create a new Imagick object and read the image from the binary data provided.
    $image = new Imagick();
    $image->readImageBlob($content);

    // Get the width and height of the image.
    $width = $image->getImageWidth();
    $height = $image->getImageHeight();

    // Create a new ImagickPixelIterator to iterate through the pixels of the image.
    $pixelIterator = $image->getPixelIterator();

    $pixels = [];

    // Loop through the rows of the image using the iterator.
    foreach ($pixelIterator as $row => $pixelRow) {
        // Loop through the pixels in the current row.
        foreach ($pixelRow as $column => $pixel) {
            // Get the RGBA color values of the pixel.
            $colors = $pixel->getColor(2);

            // Append the RGBA values to the pixels array.
            $pixels[] = $colors['r'];
            $pixels[] = $colors['g'];
            $pixels[] = $colors['b'];
            $pixels[] = $colors['a'];
        }
    }

    // Return an array containing the width, height, and pixel data.
    return [$width, $height, $pixels];
}
