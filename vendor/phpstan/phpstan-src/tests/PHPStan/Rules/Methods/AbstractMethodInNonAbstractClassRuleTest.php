<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use _PhpScoperabd03f0baf05\Bug3406\AbstractFoo;
use _PhpScoperabd03f0baf05\Bug3406\ClassFoo;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<AbstractMethodInNonAbstractClassRule>
 */
class AbstractMethodInNonAbstractClassRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Methods\AbstractMethodInNonAbstractClassRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/abstract-method.php'], [['Non-abstract class AbstractMethod\\Bar contains abstract method doBar().', 15], ['Non-abstract class AbstractMethod\\Baz contains abstract method doBar().', 22]]);
    }
    public function testTraitProblem() : void
    {
        $this->analyse([__DIR__ . '/data/trait-method-problem.php'], []);
    }
    public function testBug3406() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3406.php'], []);
    }
    public function testBug3406ReflectionCheck() : void
    {
        $this->createBroker();
        $reflectionProvider = $this->createReflectionProvider();
        $reflection = $reflectionProvider->getClass(\_PhpScoperabd03f0baf05\Bug3406\ClassFoo::class);
        $this->assertSame(\_PhpScoperabd03f0baf05\Bug3406\AbstractFoo::class, $reflection->getNativeMethod('myFoo')->getDeclaringClass()->getName());
        $this->assertSame(\_PhpScoperabd03f0baf05\Bug3406\ClassFoo::class, $reflection->getNativeMethod('myBar')->getDeclaringClass()->getName());
    }
    public function testbug3406AnotherCase() : void
    {
        $this->analyse([__DIR__ . '/data/bug-3406_2.php'], []);
    }
}
