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

    $averageColor = (new Thumbhash)->toAverageHexAlpha($encoded);

    expect($averageColor)->toBe($average_color);
})->with('images_average_color');

test('it returns the same data url', function ($hash, $sha1) {
    $dataUrl = Thumbhash::toDataURL(Thumbhash::convertStringToHash($hash));

    expect(sha1($dataUrl))->toBe($sha1);
})->with([
    ['hash' => '1QcSHQRnh493V4dIh4eXh1h4kJUI', 'sha1' => '8be88f25666f483bcadf10481f15aced2c97beac'],
    ['hash' => '3PcNNYSFeXh/d3eld0iHZoZgVwh2', 'sha1' => 'b77cec837ad8f21b2222bbed956cce8e48bedb5a'],
    ['hash' => '3OcRJYB4d3h/iIeHeEh3eIhw+j3A', 'sha1' => '181f228171b21b6f9f54f9db4fd14d59167be02b'],
    ['hash' => 'HBkSHYSIeHiPiHh8eJd4eTN0EEQG', 'sha1' => '2b8cacb50fda3c6c652b2bd47b6fc8ff75de6b32'],
    ['hash' => 'VggKDYAW6lZvdYd6d2iZh/p4GE/k', 'sha1' => 'c348e0208dc8133538638b86ab51b02725353270'],
    ['hash' => '2fcZFIB3iId/h3iJh4aIYJ2V8g', 'sha1' => '9a49d7143faffd31ac54050d31ee950c07128fb9'],
    ['hash' => 'IQgSLYZ6iHePh4h1eFeHh4dwgwg3', 'sha1' => '88ec4a72be6a50dd446d32fdf8cdbfd6c02f69eb'],
    ['hash' => 'YJqGPQw7sFlslqhFafSE+Q6oJ1h2iHB2Rw', 'sha1' => '1db9b13be1b7401b2ffb0f05bab902d15cfce421'],
    ['hash' => 'mYqDBQQnxnj0JoLYdN7f8JhpuDeHiHdwZw', 'sha1' => '28ead774ab90dcc6e6fa9201a1c4a032e52f0386'],
]);

test('it returns a valid png data url', function ($url, $hash) {
    list($width, $height, $pixels) = extract_size_and_pixels_with_imagick(file_get_contents($url));
    $dataUrl = Thumbhash::toDataURL(Thumbhash::RGBAToHash($width, $height, $pixels));

    expect($dataUrl)->toStartWith('data:image/png;base64,');

    $image = imagecreatefromstring(base64_decode(substr($dataUrl, strlen('data:image/png;base64,'))));

    expect($image)->not->toBeFalse()
        ->and(max(imagesx($image), imagesy($image)))->toBe(32);
})->with('images');
