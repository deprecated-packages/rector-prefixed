<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<OffsetAccessAssignOpRule>
 */
class OffsetAccessAssignOpRuleTest extends \PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $checkUnions;
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $ruleLevelHelper = new \PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, $this->checkUnions, \false);
        return new \PHPStan\Rules\Arrays\OffsetAccessAssignOpRule($ruleLevelHelper);
    }
    public function testRule() : void
    {
        $this->checkUnions = \true;
        $this->analyse([__DIR__ . '/data/offset-access-assignop.php'], [['Cannot assign offset \'foo\' to array|int.', 30]]);
    }
    public function testRuleWithoutUnions() : void
    {
        $this->checkUnions = \false;
        $this->analyse([__DIR__ . '/data/offset-access-assignop.php'], []);
    }
}