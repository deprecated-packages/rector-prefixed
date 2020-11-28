<?php

namespace _PhpScoperabd03f0baf05\StubsIntegrationTest;

function foo($i)
{
    return '';
}
function () {
    foo('test');
    $string = foo(1);
    foo($string);
};
