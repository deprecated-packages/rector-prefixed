<?php

namespace _PhpScopera143bcca66cb;

function () {
    if (\class_exists(\_PhpScopera143bcca66cb\UnknownClass\Foo::class)) {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScopera143bcca66cb\UnknownClass\Foo::class)) {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScopera143bcca66cb\UnknownClass\Foo::class)) {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScopera143bcca66cb\UnknownClass\Foo::class)) {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
        echo \_PhpScopera143bcca66cb\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScopera143bcca66cb\\UnknownClass\\Foo')) {
        echo \_PhpScopera143bcca66cb\UnknownClass\Foo::class;
    }
};
