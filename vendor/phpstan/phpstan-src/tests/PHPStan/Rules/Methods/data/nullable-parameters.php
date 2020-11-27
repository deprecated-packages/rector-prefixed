<?php

namespace _PhpScoper006a73f0e455\NullableParameters;

$foo = new \_PhpScoper006a73f0e455\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);
