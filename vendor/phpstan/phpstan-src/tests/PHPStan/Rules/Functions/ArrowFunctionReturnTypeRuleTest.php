<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PHPStan\Rules\FunctionReturnTypeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ArrowFunctionReturnTypeRule>
 */
class ArrowFunctionReturnTypeRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Functions\ArrowFunctionReturnTypeRule(new \PHPStan\Rules\FunctionReturnTypeCheck(new \PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false)));
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 70400) {
            $this->markTestSkipped('Test requires PHP 7.4.');
        }
        $this->analyse([__DIR__ . '/data/arrow-functions-return-type.php'], [['Anonymous function should return string but returns int.', 12], ['Anonymous function should return int but returns string.', 14]]);
    }
}
