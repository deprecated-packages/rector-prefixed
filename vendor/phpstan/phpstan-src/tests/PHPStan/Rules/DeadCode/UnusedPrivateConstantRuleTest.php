<?php

declare (strict_types=1);
namespace PHPStan\Rules\DeadCode;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<UnusedPrivateConstantRule>
 */
class UnusedPrivateConstantRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\DeadCode\UnusedPrivateConstantRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/unused-private-constant.php'], [['Constant UnusedPrivateConstant\\Foo::BAR_CONST is unused.', 10]]);
    }
}
