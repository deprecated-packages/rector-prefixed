<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase;
class RuleErrorBuilderTest extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
{
    public function testMessageAndBuild() : void
    {
        $builder = \PHPStan\Rules\RuleErrorBuilder::message('Foo');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
    }
    public function testMessageAndLineAndBuild() : void
    {
        $builder = \PHPStan\Rules\RuleErrorBuilder::message('Foo')->line(25);
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\PHPStan\Rules\LineRuleError::class, $ruleError);
        $this->assertSame(25, $ruleError->getLine());
    }
    public function testMessageAndFileAndBuild() : void
    {
        $builder = \PHPStan\Rules\RuleErrorBuilder::message('Foo')->file('Bar.php');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\PHPStan\Rules\FileRuleError::class, $ruleError);
        $this->assertSame('Bar.php', $ruleError->getFile());
    }
    public function testMessageAndLineAndFileAndBuild() : void
    {
        $builder = \PHPStan\Rules\RuleErrorBuilder::message('Foo')->line(25)->file('Bar.php');
        $ruleError = $builder->build();
        $this->assertSame('Foo', $ruleError->getMessage());
        $this->assertInstanceOf(\PHPStan\Rules\LineRuleError::class, $ruleError);
        $this->assertInstanceOf(\PHPStan\Rules\FileRuleError::class, $ruleError);
        $this->assertSame(25, $ruleError->getLine());
        $this->assertSame('Bar.php', $ruleError->getFile());
    }
}
