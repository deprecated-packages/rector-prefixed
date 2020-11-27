<?php

namespace _PhpScopera143bcca66cb\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScopera143bcca66cb\SwitchInstanceOfNot\Foo:
        die;
}
