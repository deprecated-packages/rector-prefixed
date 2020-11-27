<?php

namespace _PhpScopera143bcca66cb\ClassConstantNamespace;

\_PhpScopera143bcca66cb\ClassConstantNamespace\Foo::class;
\_PhpScopera143bcca66cb\ClassConstantNamespace\Bar::class;
self::class;
\_PhpScopera143bcca66cb\ClassConstantNamespace\Foo::LOREM;
\_PhpScopera143bcca66cb\ClassConstantNamespace\Foo::IPSUM;
\_PhpScopera143bcca66cb\ClassConstantNamespace\Foo::DOLOR;
$bar::LOREM;
$foo = new \_PhpScopera143bcca66cb\ClassConstantNamespace\Foo();
$foo::LOREM;
$foo::IPSUM;
$foo::DOLOR;
static::LOREM;
parent::LOREM;
\_PhpScopera143bcca66cb\ClassConstantNamespace\UnknownClass::FOO;
$string = 'str';
$string::FOO;
\_PhpScopera143bcca66cb\ClassConstantNamespace\FOO::class;
\_PhpScopera143bcca66cb\ClassConstantNamespace\FOO::DOLOR;
\_PhpScopera143bcca66cb\ClassConstantNamespace\FOO::LOREM;
/** @var Foo|string $fooOrString */
$fooOrString = doFoo();
$fooOrString::LOREM;
$fooOrString::DOLOR;
