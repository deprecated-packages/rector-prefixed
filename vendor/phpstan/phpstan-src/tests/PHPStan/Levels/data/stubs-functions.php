<?php

namespace _PhpScoperbd5d0c5f7638\StubsIntegrationTest;

function foo($i)
{
    return '';
}
function () {
    foo('test');
    $string = foo(1);
    foo($string);
};
