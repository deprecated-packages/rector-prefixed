<?php

namespace _PhpScoper26e51eeacccf\NullableParameters;

$foo = new \_PhpScoper26e51eeacccf\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);
