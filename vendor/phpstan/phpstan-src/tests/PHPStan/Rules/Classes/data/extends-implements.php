<?php

namespace _PhpScopera143bcca66cb\ExtendsImplements;

class Foo
{
}
class Bar extends \_PhpScopera143bcca66cb\ExtendsImplements\Foo implements \_PhpScopera143bcca66cb\ExtendsImplements\FooInterface
{
}
class Baz extends \_PhpScopera143bcca66cb\ExtendsImplements\FOO implements \_PhpScopera143bcca66cb\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \_PhpScopera143bcca66cb\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \_PhpScopera143bcca66cb\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \_PhpScopera143bcca66cb\ExtendsImplements\FinalWithAnnotation
{
}
