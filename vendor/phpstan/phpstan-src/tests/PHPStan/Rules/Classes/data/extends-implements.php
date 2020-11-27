<?php

namespace _PhpScoperbd5d0c5f7638\ExtendsImplements;

class Foo
{
}
class Bar extends \_PhpScoperbd5d0c5f7638\ExtendsImplements\Foo implements \_PhpScoperbd5d0c5f7638\ExtendsImplements\FooInterface
{
}
class Baz extends \_PhpScoperbd5d0c5f7638\ExtendsImplements\FOO implements \_PhpScoperbd5d0c5f7638\ExtendsImplements\FOOInterface
{
}
interface FooInterface
{
}
interface BarInterface extends \_PhpScoperbd5d0c5f7638\ExtendsImplements\FooInterface
{
}
interface BazInterface extends \_PhpScoperbd5d0c5f7638\ExtendsImplements\FOOInterface
{
}
/**
 * @final
 */
class FinalWithAnnotation
{
}
class ExtendsFinalWithAnnotation extends \_PhpScoperbd5d0c5f7638\ExtendsImplements\FinalWithAnnotation
{
}
