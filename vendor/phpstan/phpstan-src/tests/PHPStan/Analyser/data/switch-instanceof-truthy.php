<?php

namespace _PhpScopera143bcca66cb\SwitchInstanceOf;

/** @var object $object */
$object = doFoo();
$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch ($object) {
    case $foo instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScopera143bcca66cb\SwitchInstanceOf\Baz:
        die;
        break;
}
