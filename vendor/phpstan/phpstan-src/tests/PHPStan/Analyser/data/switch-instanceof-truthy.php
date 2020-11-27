<?php

namespace _PhpScoper26e51eeacccf\SwitchInstanceOf;

/** @var object $object */
$object = doFoo();
$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch ($object) {
    case $foo instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoper26e51eeacccf\SwitchInstanceOf\Baz:
        die;
        break;
}
