<?php

namespace _PhpScoperbd5d0c5f7638\AnnotationsProperties;

use _PhpScoperbd5d0c5f7638\OtherNamespace\Test as OtherTest;
use _PhpScoperbd5d0c5f7638\OtherNamespace\Ipsum;
/**
 * @property OtherTest $otherTest
 * @property-read Ipsum $otherTestReadOnly
 * @property self|Bar $fooOrBar
 * @property Ipsum $conflictingProperty
 * @property Foo $overridenProperty
 */
class Foo implements \_PhpScoperbd5d0c5f7638\AnnotationsProperties\FooInterface
{
    /** @var Foo */
    public $overridenPropertyWithAnnotation;
}
/**
 * @property Bar $overridenPropertyWithAnnotation
 * @property Foo $conflictingAnnotationProperty
 */
class Bar extends \_PhpScoperbd5d0c5f7638\AnnotationsProperties\Foo
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
class Baz extends \_PhpScoperbd5d0c5f7638\AnnotationsProperties\Bar
{
    use FooTrait;
}
/**
 * @property int | float $numericBazBazProperty
 */
class BazBaz extends \_PhpScoperbd5d0c5f7638\AnnotationsProperties\Baz
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
