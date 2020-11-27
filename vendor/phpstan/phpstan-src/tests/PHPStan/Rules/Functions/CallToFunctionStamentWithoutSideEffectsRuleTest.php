<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CallToFunctionStamentWithoutSideEffectsRule>
 */
class CallToFunctionStamentWithoutSideEffectsRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Functions\CallToFunctionStamentWithoutSideEffectsRule($this->createReflectionProvider());
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/function-call-statement-no-side-effects.php'], [['Call to function sprintf() on a separate line has no effect.', 11]]);
    }
}
