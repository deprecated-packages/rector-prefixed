<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<EmptyArrayItemRule>
 */
class EmptyArrayItemRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Arrays\EmptyArrayItemRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/empty-array-item.php'], [['Literal array contains empty item.', 5]]);
    }
}
