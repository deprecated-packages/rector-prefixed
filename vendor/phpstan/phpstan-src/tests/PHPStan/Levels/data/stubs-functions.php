<?php

namespace _PhpScopera143bcca66cb\StubsIntegrationTest;

function foo($i)
{
    return '';
}
function () {
    foo('test');
    $string = foo(1);
    foo($string);
};
