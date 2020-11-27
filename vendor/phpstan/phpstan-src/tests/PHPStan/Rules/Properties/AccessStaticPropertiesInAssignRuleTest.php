<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<AccessStaticPropertiesInAssignRule>
 */
class AccessStaticPropertiesInAssignRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \PHPStan\Rules\Properties\AccessStaticPropertiesInAssignRule(new \PHPStan\Rules\Properties\AccessStaticPropertiesRule($broker, new \PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false), new \PHPStan\Rules\ClassCaseSensitivityCheck($broker)));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/access-static-properties-assign.php'], [['Access to an undefined static property TestAccessStaticPropertiesAssign\\AccessStaticPropertyWithDimFetch::$foo.', 15]]);
    }
    public function testRuleExpressionNames() : void
    {
        $this->analyse([__DIR__ . '/data/properties-from-array-into-static-object.php'], [['Access to an undefined static property PropertiesFromArrayIntoStaticObject\\Foo::$noop.', 29]]);
    }
}
