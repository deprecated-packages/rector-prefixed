<?php

namespace _PhpScoper26e51eeacccf\DeadCodeNoop;

function (\_PhpScoper26e51eeacccf\DeadCodeNoop\stdClass $foo) {
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
    \_PhpScoper26e51eeacccf\DeadCodeNoop\Foo::TEST;
    (string) 1;
};
