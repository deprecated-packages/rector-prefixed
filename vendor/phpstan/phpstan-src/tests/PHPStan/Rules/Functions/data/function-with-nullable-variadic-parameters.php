<?php

namespace _PhpScoper006a73f0e455\FunctionWithNullableVariadicParameters;

function () {
    foo();
    foo(1, 2);
    foo(1, 2, 3);
    foo(1, 2, null);
    foo(...(function () : iterable {
        yield from [1, 2, 3];
    })());
};
