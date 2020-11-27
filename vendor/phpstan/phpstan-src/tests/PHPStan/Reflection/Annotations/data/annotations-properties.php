<?php

namespace _PhpScoper88fe6e0ad041\AnnotationsProperties;

use _PhpScoper88fe6e0ad041\OtherNamespace\Test as OtherTest;
use _PhpScoper88fe6e0ad041\OtherNamespace\Ipsum;
/**
 * @property OtherTest $otherTest
 * @property-read Ipsum $otherTestReadOnly
 * @property self|Bar $fooOrBar
 * @property Ipsum $conflictingProperty
 * @property Foo $overridenProperty
 */
class Foo implements \_PhpScoper88fe6e0ad041\AnnotationsProperties\FooInterface
{
    /** @var Foo */
    public $overridenPropertyWithAnnotation;
}
/**
 * @property Bar $overridenPropertyWithAnnotation
 * @property Foo $conflictingAnnotationProperty
 */
class Bar extends \_PhpScoper88fe6e0ad041\AnnotationsProperties\Foo
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
class Baz extends \_PhpScoper88fe6e0ad041\AnnotationsProperties\Bar
{
    use FooTrait;
}
/**
 * @property int | float $numericBazBazProperty
 */
class BazBaz extends \_PhpScoper88fe6e0ad041\AnnotationsProperties\Baz
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
