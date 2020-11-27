<?php

namespace _PhpScoperbd5d0c5f7638\DeadCodeNoop;

function (\_PhpScoperbd5d0c5f7638\DeadCodeNoop\stdClass $foo) {
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
    \_PhpScoperbd5d0c5f7638\DeadCodeNoop\Foo::TEST;
    (string) 1;
};
