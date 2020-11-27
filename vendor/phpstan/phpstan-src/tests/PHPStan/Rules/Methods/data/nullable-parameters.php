<?php

namespace _PhpScoperbd5d0c5f7638\NullableParameters;

$foo = new \_PhpScoperbd5d0c5f7638\NullableParameters\Foo();
$foo->doFoo();
$foo->doFoo(1);
$foo->doFoo(1, 2);
$foo->doFoo(1, null);
$foo->doFoo(1, null, 3);
