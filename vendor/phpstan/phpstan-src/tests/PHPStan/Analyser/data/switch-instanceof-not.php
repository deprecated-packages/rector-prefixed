<?php

namespace _PhpScoperabd03f0baf05\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOfNot\Foo:
        die;
}
