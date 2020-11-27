<?php

namespace _PhpScoper88fe6e0ad041\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScoper88fe6e0ad041\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScoper88fe6e0ad041\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
