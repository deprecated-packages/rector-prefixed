<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PHPStan\Php\PhpVersion;
use PHPStan\Rules\AttributesCheck;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\FunctionCallParametersCheck;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ClassAttributesRule>
 */
class ClassAttributesRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $reflectionProvider = $this->createReflectionProvider();
        return new \PHPStan\Rules\Classes\ClassAttributesRule(new \PHPStan\Rules\AttributesCheck($reflectionProvider, new \PHPStan\Rules\FunctionCallParametersCheck(new \PHPStan\Rules\RuleLevelHelper($reflectionProvider, \true, \false, \true), new \PHPStan\Rules\NullsafeCheck(), new \PHPStan\Php\PhpVersion(80000), \true, \true, \true, \true), new \PHPStan\Rules\ClassCaseSensitivityCheck($reflectionProvider, \false)));
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/class-attributes.php'], [['Attribute class ClassAttributes\\Nonexistent does not exist.', 22], ['Class ClassAttributes\\Foo is not an Attribute class.', 28], ['Class ClassAttributes\\Bar referenced with incorrect case: ClassAttributes\\baR.', 34], ['Attribute class ClassAttributes\\Baz does not have the class target.', 46], ['Attribute class ClassAttributes\\Bar is not repeatable but is already present above the class.', 59], ['Attribute class self does not exist.', 65], ['Attribute class ClassAttributes\\AbstractAttribute is abstract.', 77], ['Attribute class ClassAttributes\\Bar does not have a constructor and must be instantiated without any parameters.', 83], ['Constructor of attribute class ClassAttributes\\NonPublicConstructor is not public.', 100], ['Attribute class ClassAttributes\\AttributeWithConstructor constructor invoked with 0 parameters, 2 required.', 118], ['Attribute class ClassAttributes\\AttributeWithConstructor constructor invoked with 1 parameter, 2 required.', 119], ['Unknown parameter $r in call to ClassAttributes\\AttributeWithConstructor constructor.', 120]]);
    }
}
