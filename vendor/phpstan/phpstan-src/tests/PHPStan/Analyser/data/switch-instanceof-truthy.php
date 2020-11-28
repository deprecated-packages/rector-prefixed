<?php

namespace _PhpScoperabd03f0baf05\SwitchInstanceOf;

/** @var object $object */
$object = doFoo();
$foo = doFoo();
$bar = doBar();
$baz = doBaz();
switch ($object) {
    case $foo instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Foo:
        break;
    case $bar instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Bar:
        break;
    case $baz instanceof \_PhpScoperabd03f0baf05\SwitchInstanceOf\Baz:
        die;
        break;
}
