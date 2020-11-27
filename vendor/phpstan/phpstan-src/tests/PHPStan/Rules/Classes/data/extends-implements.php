<?php

namespace _PhpScoper26e51eeacccf\ExtendsImplements;

class Foo
{
}
class Bar extends \_PhpScoper26e51eeacccf\ExtendsImplements\Foo implements \_PhpScoper26e51eeacccf\ExtendsImplements\FooInterface
{
}
class Baz extends \_PhpScoper26e51eeacccf\ExtendsImplements\FOO implements \_PhpScoper26e51eeacccf\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \_PhpScoper26e51eeacccf\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \_PhpScoper26e51eeacccf\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \_PhpScoper26e51eeacccf\ExtendsImplements\FinalWithAnnotation
{
}
