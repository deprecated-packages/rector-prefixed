<?php

declare (strict_types=1);
namespace PHPStan\Rules\TooWideTypehints;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TooWideClosureReturnTypehintRule>
 */
class TooWideClosureReturnTypehintRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\TooWideTypehints\TooWideClosureReturnTypehintRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/tooWideClosureReturnType.php'], [['Anonymous function never returns null so it can be removed from the return typehint.', 20]]);
    }
}
