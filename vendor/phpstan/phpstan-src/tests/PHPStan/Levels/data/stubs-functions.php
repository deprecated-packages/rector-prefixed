<?php

namespace _PhpScoper26e51eeacccf\StubsIntegrationTest;

function foo($i)
{
    return '';
}
function () {
    foo('test');
    $string = foo(1);
    foo($string);
};
