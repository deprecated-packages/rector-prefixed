<?php

namespace _PhpScoperabd03f0baf05\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Baz:
        die;
        break;
}
