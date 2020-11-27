<?php

namespace _PhpScoper26e51eeacccf\ClassConstantNamespace;

\_PhpScoper26e51eeacccf\ClassConstantNamespace\Foo::class;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\Bar::class;
self::class;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\Foo::LOREM;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\Foo::IPSUM;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\Foo::DOLOR;
$bar::LOREM;
$foo = new \_PhpScoper26e51eeacccf\ClassConstantNamespace\Foo();
$foo::LOREM;
$foo::IPSUM;
$foo::DOLOR;
static::LOREM;
parent::LOREM;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\UnknownClass::FOO;
$string = 'str';
$string::FOO;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\FOO::class;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\FOO::DOLOR;
\_PhpScoper26e51eeacccf\ClassConstantNamespace\FOO::LOREM;
/** @var Foo|string $fooOrString */
$fooOrString = doFoo();
$fooOrString::LOREM;
$fooOrString::DOLOR;
