<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
class AnonymousClassNameRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Analyser\AnonymousClassNameRule($broker);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/anonymous-class-name.php'], [['found', 6]]);
    }
}
