<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ClosureUsesThisRule>
 */
class ClosureUsesThisRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Functions\ClosureUsesThisRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/closure-uses-this.php'], [['Anonymous function uses $this assigned to variable $that. Use $this directly in the function body.', 16]]);
    }
}
