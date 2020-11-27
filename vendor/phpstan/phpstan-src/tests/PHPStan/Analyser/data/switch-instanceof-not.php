<?php

namespace _PhpScoper006a73f0e455\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScoper006a73f0e455\SwitchInstanceOfNot\Foo:
        die;
}
