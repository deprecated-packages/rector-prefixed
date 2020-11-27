<?php

namespace _PhpScoperbd5d0c5f7638\ExtendingKnownClassWithCheck;

if (\class_exists(\_PhpScoperbd5d0c5f7638\ExtendingKnownClassWithCheck\Bar::class)) {
    class Foo extends \_PhpScoperbd5d0c5f7638\ExtendingKnownClassWithCheck\Bar
    {
    }
} else {
    class Foo extends \Exception
    {
    }
}
