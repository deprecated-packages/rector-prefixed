<?php

namespace _PhpScoperbd5d0c5f7638\FunctionWithNullableVariadicParameters;

function () {
    foo();
    foo(1, 2);
    foo(1, 2, 3);
    foo(1, 2, null);
    foo(...(function () : iterable {
        yield from [1, 2, 3];
    })());
};
