<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<TraitTemplateTypeRule>
 */
class TraitTemplateTypeRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Generics\TraitTemplateTypeRule(self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class), new \PHPStan\Rules\Generics\TemplateTypeCheck($broker, new \PHPStan\Rules\ClassCaseSensitivityCheck($broker), ['TypeAlias' => 'int'], \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/trait-template.php'], [['PHPDoc tag @template for trait TraitTemplateType\\Foo cannot have existing class stdClass as its name.', 8], ['PHPDoc tag @template T for trait TraitTemplateType\\Bar has invalid bound type TraitTemplateType\\Zazzzu.', 16], ['PHPDoc tag @template T for trait TraitTemplateType\\Baz with bound type int is not supported.', 24], ['PHPDoc tag @template for trait TraitTemplateType\\Lorem cannot have existing type alias TypeAlias as its name.', 32]]);
    }
}
