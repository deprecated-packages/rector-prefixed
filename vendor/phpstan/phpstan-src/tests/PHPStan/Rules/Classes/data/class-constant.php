<?php

namespace _PhpScoperbd5d0c5f7638\ClassConstantNamespace;

\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Foo::class;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Bar::class;
self::class;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Foo::LOREM;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Foo::IPSUM;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Foo::DOLOR;
$bar::LOREM;
$foo = new \_PhpScoperbd5d0c5f7638\ClassConstantNamespace\Foo();
$foo::LOREM;
$foo::IPSUM;
$foo::DOLOR;
static::LOREM;
parent::LOREM;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\UnknownClass::FOO;
$string = 'str';
$string::FOO;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\FOO::class;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\FOO::DOLOR;
\_PhpScoperbd5d0c5f7638\ClassConstantNamespace\FOO::LOREM;
/** @var Foo|string $fooOrString */
$fooOrString = doFoo();
$fooOrString::LOREM;
$fooOrString::DOLOR;
