<?php

namespace _PhpScoper88fe6e0ad041\DeadCodeNoop;

function (\_PhpScoper88fe6e0ad041\DeadCodeNoop\stdClass $foo) {
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
    \_PhpScoper88fe6e0ad041\DeadCodeNoop\Foo::TEST;
    (string) 1;
};
