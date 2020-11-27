<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<NonClassAttributeClassRule>
 */
class NonClassAttributeClassRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\Classes\NonClassAttributeClassRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/non-class-attribute-class.php'], [
            ['Interface cannot be an Attribute class.', 5],
            /* [ reported by a separate rule
            				'Trait cannot be an Attribute class.',
            				11,
            			], */
            ['Abstract class NonClassAttributeClass\\Lorem cannot be an Attribute class.', 23],
            ['Attribute class NonClassAttributeClass\\Ipsum constructor must be public.', 29],
        ]);
    }
}
