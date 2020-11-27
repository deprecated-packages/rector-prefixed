<?php

namespace _PhpScopera143bcca66cb\NullableParameters;

$foo = new \_PhpScopera143bcca66cb\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);
