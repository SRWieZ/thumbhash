<?php

use Thumbhash\Thumbhash;
use function Thumbhash\extract_size_and_pixels_with_imagick;

test('it returns the correct hash', function ($url, $hash) {

    $content = file_get_contents($url);

    list($width, $height, $pixels) = extract_size_and_pixels_with_imagick($content);

    $encoded = Thumbhash::RGBAToHash($width, $height, $pixels);
    $encodedBase64 = Thumbhash::convertHashToString($encoded);

    expect($encodedBase64)->toBe($hash);
})
->with('images');

test('it returns the correct average color', function ($url, $average_color) {

    $content = file_get_contents($url);

    list($width, $height, $pixels) = extract_size_and_pixels_with_imagick($content);

    $encoded = Thumbhash::RGBAToHash($width, $height, $pixels);

    $averageColor = (new Thumbhash)->toAverageColor($encoded);

    expect($averageColor)->toBe($average_color);
})->with('images_average_color');
