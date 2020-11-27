<?php

namespace _PhpScopera143bcca66cb\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScopera143bcca66cb\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScopera143bcca66cb\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
