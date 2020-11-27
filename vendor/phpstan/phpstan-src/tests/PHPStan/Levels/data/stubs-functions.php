<?php

namespace _PhpScoper006a73f0e455\StubsIntegrationTest;

function foo($i)
{
    return '';
}
function () {
    foo('test');
    $string = foo(1);
    foo($string);
};
