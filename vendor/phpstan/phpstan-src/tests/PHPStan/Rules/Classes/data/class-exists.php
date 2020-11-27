<?php

namespace _PhpScoper006a73f0e455;

function () {
    if (\class_exists(\_PhpScoper006a73f0e455\UnknownClass\Foo::class)) {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScoper006a73f0e455\UnknownClass\Foo::class)) {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScoper006a73f0e455\UnknownClass\Foo::class)) {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScoper006a73f0e455\UnknownClass\Foo::class)) {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
        echo \_PhpScoper006a73f0e455\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScoper006a73f0e455\\UnknownClass\\Foo')) {
        echo \_PhpScoper006a73f0e455\UnknownClass\Foo::class;
    }
};
