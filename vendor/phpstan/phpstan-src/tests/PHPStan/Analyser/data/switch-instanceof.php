<?php

namespace _PhpScoper26e51eeacccf\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Baz:
        die;
        break;
}
