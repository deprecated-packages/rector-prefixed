<?php

namespace _PhpScoper26e51eeacccf\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScoper26e51eeacccf\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScoper26e51eeacccf\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
