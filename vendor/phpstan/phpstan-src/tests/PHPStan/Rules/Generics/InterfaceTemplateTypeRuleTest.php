<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InterfaceTemplateTypeRule>
 */
class InterfaceTemplateTypeRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Generics\InterfaceTemplateTypeRule(self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class), new \PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/interface-template.php'], [['PHPDoc tag @template for interface InterfaceTemplateType\\Foo cannot have existing class stdClass as its name.', 8], ['PHPDoc tag @template T for interface InterfaceTemplateType\\Bar has invalid bound type InterfaceTemplateType\\Zazzzu.', 16], ['PHPDoc tag @template T for interface InterfaceTemplateType\\Baz with bound type int is not supported.', 24], ['PHPDoc tag @template for interface InterfaceTemplateType\\Lorem cannot have existing type alias TypeAlias as its name.', 32]]);
    }
}
