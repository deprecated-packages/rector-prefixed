<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CallToStaticMethodStamentWithoutSideEffectsRule>
 */
class CallToStaticMethodStamentWithoutSideEffectsRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Methods\CallToStaticMethodStamentWithoutSideEffectsRule(new \PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false), $broker);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/static-method-call-statement-no-side-effects.php'], [['Call to static method DateTimeImmutable::createFromFormat() on a separate line has no effect.', 12], ['Call to static method DateTimeImmutable::createFromFormat() on a separate line has no effect.', 13], ['Call to method DateTime::format() on a separate line has no effect.', 23]]);
    }
}
