<?php

namespace _PhpScoper88fe6e0ad041\ExtendsImplements;

class Foo
{
}
class Bar extends \_PhpScoper88fe6e0ad041\ExtendsImplements\Foo implements \_PhpScoper88fe6e0ad041\ExtendsImplements\FooInterface
{
}
class Baz extends \_PhpScoper88fe6e0ad041\ExtendsImplements\FOO implements \_PhpScoper88fe6e0ad041\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \_PhpScoper88fe6e0ad041\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \_PhpScoper88fe6e0ad041\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \_PhpScoper88fe6e0ad041\ExtendsImplements\FinalWithAnnotation
{
}
