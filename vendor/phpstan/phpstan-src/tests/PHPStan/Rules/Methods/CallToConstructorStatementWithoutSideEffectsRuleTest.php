<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<CallToConstructorStatementWithoutSideEffectsRule>
 */
class CallToConstructorStatementWithoutSideEffectsRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Methods\CallToConstructorStatementWithoutSideEffectsRule($this->createReflectionProvider());
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/constructor-statement-no-side-effects.php'], [['Call to Exception::__construct() on a separate line has no effect.', 6]]);
    }
}
