<?php

namespace _PhpScoper26e51eeacccf\InstanceOfNamespace;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use function PHPStan\Analyser\assertType;
interface BarInterface
{
}
abstract class BarParent
{
}
class Foo extends \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarParent
{
    public function someMethod(\PhpParser\Node\Expr $foo)
    {
        $bar = $foo;
        $baz = doFoo();
        $intersected = new \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo();
        $parent = doFoo();
        if ($baz instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo) {
            // ...
        } else {
            while ($foo instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
                \assert($lorem instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Lorem);
                if ($dolor instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Dolor && $sit instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Sit) {
                    if ($static instanceof static) {
                        if ($self instanceof self) {
                            if ($intersected instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface) {
                                if ($this instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface) {
                                    if ($parent instanceof parent) {
                                        \PHPStan\Analyser\assertType('PhpParser\\Node\\Expr\\ArrayDimFetch', $foo);
                                        \PHPStan\Analyser\assertType('PhpParser\\Node\\Expr', $bar);
                                        \PHPStan\Analyser\assertType('*ERROR*', $baz);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Lorem', $lorem);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Dolor', $dolor);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Sit', $sit);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Foo', $self);
                                        \PHPStan\Analyser\assertType('static(InstanceOfNamespace\\Foo)', $static);
                                        \PHPStan\Analyser\assertType('static(InstanceOfNamespace\\Foo)', clone $static);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $intersected);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\$this(InstanceOfNamespace\\Foo)&InstanceOfNamespace\\BarInterface', $this);
                                        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarParent', $parent);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     * @template ObjectT of BarInterface
     * @template MixedT
     *
     * @param class-string<Foo> $classString
     * @param class-string<Foo>|class-string<BarInterface> $union
     * @param class-string<Foo>&class-string<BarInterface> $intersection
     * @param BarInterface $instance
     * @param ObjectT $objectT
     * @param class-string<ObjectT> $objectTString
     * @param class-string<MixedT> $mixedTString
     * @param object $object
     */
    public function testExprInstanceof($subject, string $classString, $union, $intersection, string $other, $instance, $objectT, $objectTString, $mixedTString, string $string, $object)
    {
        \PHPStan\Analyser\assertType('bool', $subject instanceof $classString);
        if ($subject instanceof $classString) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Foo', $subject);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $classString);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\mixed~InstanceOfNamespace\\Foo', $subject);
            \PHPStan\Analyser\assertType('false', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo);
            \PHPStan\Analyser\assertType('false', $subject instanceof $classString);
        }
        $constantString = '_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarParent';
        \PHPStan\Analyser\assertType('bool', $subject instanceof $constantString);
        if ($subject instanceof $constantString) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarParent', $subject);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarParent);
            \PHPStan\Analyser\assertType('true', $subject instanceof $constantString);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\mixed~InstanceOfNamespace\\BarParent', $subject);
            \PHPStan\Analyser\assertType('false', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarParent);
            \PHPStan\Analyser\assertType('false', $subject instanceof $constantString);
        }
        \PHPStan\Analyser\assertType('bool', $subject instanceof $union);
        if ($subject instanceof $union) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface|InstanceOfNamespace\\Foo', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $union);
            \PHPStan\Analyser\assertType('bool', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface);
            \PHPStan\Analyser\assertType('bool', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo || $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface);
        }
        if ($subject instanceof $intersection) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $intersection);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\Foo);
        }
        if ($subject instanceof $instance) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $instance);
            \PHPStan\Analyser\assertType('true', $subject instanceof \_PhpScoper26e51eeacccf\InstanceOfNamespace\BarInterface);
        }
        if ($subject instanceof $other) {
            \PHPStan\Analyser\assertType('object', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $other);
        } else {
            \PHPStan\Analyser\assertType('mixed', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $other);
        }
        if ($subject instanceof $objectT) {
            \PHPStan\Analyser\assertType('ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $objectT);
        } else {
            \PHPStan\Analyser\assertType('mixed~ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \PHPStan\Analyser\assertType('false', $subject instanceof $objectT);
        }
        if ($subject instanceof $objectTString) {
            \PHPStan\Analyser\assertType('ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $objectTString);
        } else {
            \PHPStan\Analyser\assertType('mixed~ObjectT of InstanceOfNamespace\\BarInterface (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \PHPStan\Analyser\assertType('false', $subject instanceof $objectTString);
        }
        if ($subject instanceof $mixedTString) {
            \PHPStan\Analyser\assertType('MixedT (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)&object', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $mixedTString);
        } else {
            \PHPStan\Analyser\assertType('mixed~MixedT (method InstanceOfNamespace\\Foo::testExprInstanceof(), argument)', $subject);
            \PHPStan\Analyser\assertType('false', $subject instanceof $mixedTString);
        }
        if ($subject instanceof $string) {
            \PHPStan\Analyser\assertType('object', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $string);
        } else {
            \PHPStan\Analyser\assertType('mixed', $subject);
            \PHPStan\Analyser\assertType('bool', $subject instanceof $string);
        }
        if ($object instanceof $string) {
            \PHPStan\Analyser\assertType('object', $object);
            \PHPStan\Analyser\assertType('bool', $object instanceof $string);
        } else {
            \PHPStan\Analyser\assertType('object', $object);
            \PHPStan\Analyser\assertType('bool', $object instanceof $string);
        }
        if ($object instanceof $object) {
            \PHPStan\Analyser\assertType('object', $object);
            \PHPStan\Analyser\assertType('bool', $object instanceof $object);
        } else {
            \PHPStan\Analyser\assertType('object', $object);
            \PHPStan\Analyser\assertType('bool', $object instanceof $object);
        }
        if ($object instanceof $classString) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\Foo', $object);
            \PHPStan\Analyser\assertType('bool', $object instanceof $classString);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\object~InstanceOfNamespace\\Foo', $object);
            \PHPStan\Analyser\assertType('false', $object instanceof $classString);
        }
        if ($instance instanceof $string) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $instance);
            \PHPStan\Analyser\assertType('bool', $instance instanceof $string);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $instance);
            \PHPStan\Analyser\assertType('bool', $instance instanceof $string);
        }
        if ($instance instanceof $object) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $instance);
            \PHPStan\Analyser\assertType('bool', $instance instanceof $object);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $instance);
            \PHPStan\Analyser\assertType('bool', $object instanceof $object);
        }
        if ($instance instanceof $classString) {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface&InstanceOfNamespace\\Foo', $instance);
            \PHPStan\Analyser\assertType('bool', $instance instanceof $classString);
        } else {
            \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InstanceOfNamespace\\BarInterface', $instance);
            \PHPStan\Analyser\assertType('bool', $instance instanceof $classString);
        }
    }
}
