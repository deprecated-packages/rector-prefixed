<?php

declare (strict_types=1);
namespace PHPStan\Rules\Namespaces;

use PHPStan\Rules\ClassCaseSensitivityCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingNamesInGroupUseRule>
 */
class ExistingNamesInGroupUseRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Namespaces\ExistingNamesInGroupUseRule($broker, new \PHPStan\Rules\ClassCaseSensitivityCheck($broker), \true);
    }
    public function testRule() : void
    {
        require_once __DIR__ . '/data/uses-defined.php';
        $this->analyse([__DIR__ . '/data/group-uses.php'], [['Function Uses\\foo used with incorrect case: Uses\\Foo.', 6], ['Used function Uses\\baz not found.', 7, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Interface Uses\\Lorem referenced with incorrect case: Uses\\LOREM.', 11], ['Function Uses\\foo used with incorrect case: Uses\\Foo.', 13], ['Used constant Uses\\OTHER_CONSTANT not found.', 15, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
}