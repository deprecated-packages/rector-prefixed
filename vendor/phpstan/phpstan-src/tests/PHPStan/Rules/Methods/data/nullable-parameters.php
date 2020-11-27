<?php

namespace _PhpScoper88fe6e0ad041\NullableParameters;

$foo = new \_PhpScoper88fe6e0ad041\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);
