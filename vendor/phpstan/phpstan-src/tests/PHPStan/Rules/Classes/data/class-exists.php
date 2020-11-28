<?php

namespace _PhpScoperabd03f0baf05;

function () {
    if (\class_exists(\_PhpScoperabd03f0baf05\UnknownClass\Foo::class)) {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScoperabd03f0baf05\UnknownClass\Foo::class)) {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScoperabd03f0baf05\UnknownClass\Foo::class)) {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScoperabd03f0baf05\UnknownClass\Foo::class)) {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
        echo \_PhpScoperabd03f0baf05\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScoperabd03f0baf05\\UnknownClass\\Foo')) {
        echo \_PhpScoperabd03f0baf05\UnknownClass\Foo::class;
    }
};
