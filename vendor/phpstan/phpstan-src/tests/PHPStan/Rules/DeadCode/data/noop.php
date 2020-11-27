<?php

namespace _PhpScopera143bcca66cb\DeadCodeNoop;

function (\_PhpScopera143bcca66cb\DeadCodeNoop\stdClass $foo) {
    $foo->foo();
    $arr = [];
    $arr;
    $arr['test'];
    $foo::$test;
    $foo->test;
    'foo';
    1;
    @'foo';
    +1;
    -1;
    +$foo->foo();
    -$foo->foo();
    @$foo->foo();
    isset($test);
    empty($test);
    \true;
    \_PhpScopera143bcca66cb\DeadCodeNoop\Foo::TEST;
    (string) 1;
};
