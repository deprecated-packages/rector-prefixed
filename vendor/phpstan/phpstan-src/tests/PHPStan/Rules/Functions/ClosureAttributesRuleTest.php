<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PHPStan\Php\PhpVersion;
use PHPStan\Rules\AttributesCheck;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\FunctionCallParametersCheck;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ClosureAttributesRule>
 */
class ClosureAttributesRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $reflectionProvider = $this->createReflectionProvider();
        return new \PHPStan\Rules\Functions\ClosureAttributesRule(new \PHPStan\Rules\AttributesCheck($reflectionProvider, new \PHPStan\Rules\FunctionCallParametersCheck(new \PHPStan\Rules\RuleLevelHelper($reflectionProvider, \true, \false, \true), new \PHPStan\Rules\NullsafeCheck(), new \PHPStan\Php\PhpVersion(80000), \true, \true, \true, \true), new \PHPStan\Rules\ClassCaseSensitivityCheck($reflectionProvider, \false)));
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/closure-attributes.php'], [['Attribute class ClosureAttributes\\Foo does not have the function target.', 28]]);
    }
}
