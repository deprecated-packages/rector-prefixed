<?php

namespace _PhpScoper006a73f0e455\ExtendsImplements;

class Foo
{
}
class Bar extends \_PhpScoper006a73f0e455\ExtendsImplements\Foo implements \_PhpScoper006a73f0e455\ExtendsImplements\FooInterface
{
}
class Baz extends \_PhpScoper006a73f0e455\ExtendsImplements\FOO implements \_PhpScoper006a73f0e455\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \_PhpScoper006a73f0e455\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \_PhpScoper006a73f0e455\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \_PhpScoper006a73f0e455\ExtendsImplements\FinalWithAnnotation
{
}
