<?php

namespace _PhpScoper006a73f0e455\DeadCodeNoop;

function (\_PhpScoper006a73f0e455\DeadCodeNoop\stdClass $foo) {
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
    \_PhpScoper006a73f0e455\DeadCodeNoop\Foo::TEST;
    (string) 1;
};
