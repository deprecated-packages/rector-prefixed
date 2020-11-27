<?php

namespace _PhpScoper26e51eeacccf\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOfNot\Foo:
        die;
}
