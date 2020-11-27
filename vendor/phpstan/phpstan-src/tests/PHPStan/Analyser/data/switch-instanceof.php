<?php

namespace _PhpScoper006a73f0e455\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \_PhpScoper006a73f0e455\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoper006a73f0e455\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoper006a73f0e455\SwitchInstanceOf\Baz:
        die;
        break;
}
