<?php

it('throws exception if pixel width or height > 100 ', function () {
    \Thumbhash\Thumbhash::RGBAToHash(101, 100, []);
})->throws(Exception::class);