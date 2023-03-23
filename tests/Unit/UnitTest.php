<?php

it('throws exception if pixel width or height > 100 ', function () {
    \Thumbhash\Thumbhash::encode(101, 100, []);
})->throws(Exception::class);