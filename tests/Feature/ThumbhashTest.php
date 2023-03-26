<?php

use Thumbhash\Thumbhash;
// use function Thumbhash\extract_size_and_pixels_with_imagick;

test('it returns the correct hash', function ($url, $hash) {

    $Th = new Thumbhash($url);

    $encodedBase64 = $Th->getHash();

    expect($encodedBase64)->toBe($hash);
})
->with('images');
