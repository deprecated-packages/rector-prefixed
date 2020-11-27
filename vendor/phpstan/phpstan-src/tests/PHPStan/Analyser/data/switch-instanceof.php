<?php

namespace _PhpScoperbd5d0c5f7638\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoperbd5d0c5f7638\SwitchInstanceOf\Baz:
        die;
        break;
}
