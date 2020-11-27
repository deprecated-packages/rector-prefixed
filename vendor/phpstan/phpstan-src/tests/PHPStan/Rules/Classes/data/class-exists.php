<?php

namespace _PhpScoperbd5d0c5f7638;

function () {
    if (\class_exists(\_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class)) {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
    }
};
function () {
    if (\interface_exists(\_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class)) {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
    }
};
function () {
    if (\trait_exists(\_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class)) {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
    }
};
function () {
    if (\class_exists(\_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class)) {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Bar::class;
        // error
    } else {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
        // error
    }
    echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
    // error
};
function () {
    if (\class_exists('_PhpScoperbd5d0c5f7638\\UnknownClass\\Foo')) {
        echo \_PhpScoperbd5d0c5f7638\UnknownClass\Foo::class;
    }
};
