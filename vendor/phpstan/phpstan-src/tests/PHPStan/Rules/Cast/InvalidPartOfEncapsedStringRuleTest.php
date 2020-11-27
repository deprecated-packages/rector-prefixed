<?php

declare (strict_types=1);
namespace PHPStan\Rules\Cast;

use PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidPartOfEncapsedStringRule>
 */
class InvalidPartOfEncapsedStringRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Cast\InvalidPartOfEncapsedStringRule(new \PhpParser\PrettyPrinter\Standard(), new \PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-encapsed-part.php'], [['Part $std (stdClass) of encapsed string cannot be cast to string.', 8]]);
    }
}
