<?php

namespace _PhpScoper006a73f0e455\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScoper006a73f0e455\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScoper006a73f0e455\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
