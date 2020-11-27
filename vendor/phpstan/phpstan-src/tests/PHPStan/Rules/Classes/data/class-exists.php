<?php

namespace _PhpScoper88fe6e0ad041;

function () {
    if (\class_exists(\_PhpScoper88fe6e0ad041\UnknownClass\Foo::class)) {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScoper88fe6e0ad041\UnknownClass\Foo::class)) {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScoper88fe6e0ad041\UnknownClass\Foo::class)) {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScoper88fe6e0ad041\UnknownClass\Foo::class)) {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScoper88fe6e0ad041\\UnknownClass\\Foo')) {
        echo \_PhpScoper88fe6e0ad041\UnknownClass\Foo::class;
    }
};
