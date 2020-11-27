<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<MethodTemplateTypeRule>
 */
class MethodTemplateTypeRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Generics\MethodTemplateTypeRule(self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class), new \PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/method-template.php'], [['PHPDoc tag @template for method MethodTemplateType\\Foo::doFoo() cannot have existing class stdClass as its name.', 11], ['PHPDoc tag @template T for method MethodTemplateType\\Foo::doBar() has invalid bound type MethodTemplateType\\Zazzzu.', 19], ['PHPDoc tag @template T for method MethodTemplateType\\Bar::doFoo() shadows @template T of Exception for class MethodTemplateType\\Bar.', 37], ['PHPDoc tag @template T for method MethodTemplateType\\Baz::doFoo() with bound type int is not supported.', 50], ['PHPDoc tag @template for method MethodTemplateType\\Lorem::doFoo() cannot have existing type alias TypeAlias as its name.', 63]]);
    }
}
