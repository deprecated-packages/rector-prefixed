<?php

namespace _PhpScoper26e51eeacccf;

function () {
    if (\class_exists(\_PhpScoper26e51eeacccf\UnknownClass\Foo::class)) {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScoper26e51eeacccf\UnknownClass\Foo::class)) {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScoper26e51eeacccf\UnknownClass\Foo::class)) {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScoper26e51eeacccf\UnknownClass\Foo::class)) {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
        echo \_PhpScoper26e51eeacccf\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScoper26e51eeacccf\\UnknownClass\\Foo')) {
        echo \_PhpScoper26e51eeacccf\UnknownClass\Foo::class;
    }
};
