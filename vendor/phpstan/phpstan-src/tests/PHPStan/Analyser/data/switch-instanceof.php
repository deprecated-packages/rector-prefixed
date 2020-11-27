<?php

namespace _PhpScopera143bcca66cb\SwitchInstanceOf;

$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch (\true) {
    case $foo instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Baz:
        die;
        break;
}
