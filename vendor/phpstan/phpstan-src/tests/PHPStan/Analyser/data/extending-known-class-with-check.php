<?php

namespace _PhpScoperabd03f0baf05\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScoperabd03f0baf05\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScoperabd03f0baf05\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
