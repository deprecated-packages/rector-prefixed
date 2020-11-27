<?php

namespace _PhpScopera143bcca66cb\FunctionWithNullableVariadicParameters;

function () {
    foo();
    foo(1, 2);
    foo(1, 2, 3);
    foo(1, 2, null);
    foo(...(function () : iterable {
        yield from [1, 2, 3];
    })());
};
