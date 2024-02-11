<?php

use Thumbhash\Thumbhash;
use function Thumbhash\extract_size_and_pixels_with_gd;
use function Thumbhash\extract_size_and_pixels_with_imagick;

it('throws exception if pixel width or height > 100 ', function () {
    Thumbhash::RGBAToHash(101, 100, []);
})->throws(Exception::class);

it('throws exception if gd cannot decode the image data', function () {
    extract_size_and_pixels_with_gd('not an image');
})->throws(Exception::class);

it('throws exception if imagick cannot decode the image data', function () {
    extract_size_and_pixels_with_imagick('not an image');
})->throws(Exception::class);

it('throws exception if imagick pixel iterator cannot decode the image data', function () {
    \Thumbhash\extract_size_and_pixels_with_imagick_pixel_iterator('not an image');
})->throws(Exception::class);