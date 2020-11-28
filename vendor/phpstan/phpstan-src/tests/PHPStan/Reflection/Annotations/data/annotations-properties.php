<?php

namespace _PhpScoperabd03f0baf05\AnnotationsProperties;

use _PhpScoperabd03f0baf05\OtherNamespace\Test as OtherTest;
use _PhpScoperabd03f0baf05\OtherNamespace\Ipsum;
/**
 * @property OtherTest $otherTest
 * @property-read Ipsum $otherTestReadOnly
 * @property self|Bar $fooOrBar
 * @property Ipsum $conflictingProperty
 * @property Foo $overridenProperty
 */
class Foo implements \_PhpScoperabd03f0baf05\AnnotationsProperties\FooInterface
{
    /** @var Foo */
    public $overridenPropertyWithAnnotation;
}
/**
 * @property Bar $overridenPropertyWithAnnotation
 * @property Foo $conflictingAnnotationProperty
 */
class Bar extends \_PhpScoperabd03f0baf05\AnnotationsProperties\Foo
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
class Baz extends \_PhpScoperabd03f0baf05\AnnotationsProperties\Bar
{
    use FooTrait;
}
/**
 * @property int | float $numericBazBazProperty
 */
class BazBaz extends \_PhpScoperabd03f0baf05\AnnotationsProperties\Baz
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
