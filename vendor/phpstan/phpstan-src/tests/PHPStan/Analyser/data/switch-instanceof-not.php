<?php

namespace _PhpScoperbd5d0c5f7638\SwitchInstanceOfNot;

$foo = doFoo();
switch (\false) {
    case $foo instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOfNot\Foo:
        die;
}
