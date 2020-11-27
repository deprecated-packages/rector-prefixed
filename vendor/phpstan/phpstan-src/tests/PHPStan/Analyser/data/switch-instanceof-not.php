<?php

namespace _PhpScoper88fe6e0ad041\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScoper88fe6e0ad041\SwitchInstanceOfNot\Foo:
        die;
}
