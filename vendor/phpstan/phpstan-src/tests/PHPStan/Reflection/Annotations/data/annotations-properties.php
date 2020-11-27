<?php

namespace _PhpScopera143bcca66cb\AnnotationsProperties;

use _PhpScopera143bcca66cb\OtherNamespace\Test as OtherTest;
use _PhpScopera143bcca66cb\OtherNamespace\Ipsum;
/**
 * @property OtherTest $otherTest
 * @property-read Ipsum $otherTestReadOnly
 * @property self|Bar $fooOrBar
 * @property Ipsum $conflictingProperty
 * @property Foo $overridenProperty
 */
class Foo implements \_PhpScopera143bcca66cb\AnnotationsProperties\FooInterface
{
    /** @var Foo */
    public $overridenPropertyWithAnnotation;
}
/**
 * @property Bar $overridenPropertyWithAnnotation
 * @property Foo $conflictingAnnotationProperty
 */
class Bar extends \_PhpScopera143bcca66cb\AnnotationsProperties\Foo
{
    /** @var Bar */
    public $overridenProperty;
    /** @var Bar */
    public $conflictingAnnotationProperty;
}
/**
 * @property   Lorem  $bazProperty
 * @property Dolor $conflictingProperty
 * @property-write ?Lorem $writeOnlyProperty
 */
class Baz extends \_PhpScopera143bcca66cb\AnnotationsProperties\Bar
{
    use FooTrait;
}
/**
 * @property int | float $numericBazBazProperty
 */
class BazBaz extends \_PhpScopera143bcca66cb\AnnotationsProperties\Baz
{
}
/**
 * @property FooInterface $interfaceProperty
 */
interface FooInterface
{
}
/**
 * @property BazBaz $traitProperty
 */
trait FooTrait
{
}
