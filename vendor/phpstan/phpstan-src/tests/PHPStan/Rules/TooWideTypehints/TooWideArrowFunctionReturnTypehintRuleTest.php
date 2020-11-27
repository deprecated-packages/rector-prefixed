<?php

declare (strict_types=1);
namespace PHPStan\Rules\TooWideTypehints;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TooWideArrowFunctionReturnTypehintRule>
 */
class TooWideArrowFunctionReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\TooWideTypehints\TooWideArrowFunctionReturnTypehintRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 70400) {
            $this->markTestSkipped('Test requires PHP 7.4.');
        }
        $this->analyse([__DIR__ . '/data/tooWideArrowFunctionReturnType.php'], [['Anonymous function never returns null so it can be removed from the return typehint.', 14]]);
    }
}
