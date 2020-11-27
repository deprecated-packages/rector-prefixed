<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<FunctionSignatureVarianceRule>
 */
class FunctionSignatureVarianceRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Generics\FunctionSignatureVarianceRule(self::getContainer()->getByType(\PHPStan\Rules\Generics\VarianceCheck::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/function-signature-variance.php'], [['Variance annotation is only allowed for type parameters of classes and interfaces, but occurs in template type T in in function FunctionSignatureVariance\\f().', 20]]);
    }
}
