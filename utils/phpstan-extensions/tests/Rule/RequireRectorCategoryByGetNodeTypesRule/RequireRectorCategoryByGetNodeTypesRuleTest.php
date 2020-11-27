<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Tests\Rule\RequireRectorCategoryByGetNodeTypesRule;

use Iterator;
use PHPStan\Rules\Rule;
use Rector\PHPStanExtensions\Rule\RequireRectorCategoryByGetNodeTypesRule;
use Rector\PHPStanExtensions\Tests\Rule\RequireRectorCategoryByGetNodeTypesRule\Fixture\ClassMethod\ChangeSomethingRector;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;
final class RequireRectorCategoryByGetNodeTypesRuleTest extends \Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param array<string|string[]|int[]> $expectedErrorsWithLines
     */
    public function testRule(string $filePath, array $expectedErrorsWithLines) : void
    {
        $this->analyse([$filePath], $expectedErrorsWithLines);
    }
    public function provideData() : \Iterator
    {
        $errorMessage = \sprintf(\Rector\PHPStanExtensions\Rule\RequireRectorCategoryByGetNodeTypesRule::ERROR_MESSAGE, \Rector\PHPStanExtensions\Tests\Rule\RequireRectorCategoryByGetNodeTypesRule\Fixture\ClassMethod\ChangeSomethingRector::class, 'ClassMethod', 'String_');
        (yield [__DIR__ . '/Fixture/ClassMethod/ChangeSomethingRector.php', [[$errorMessage, 14]]]);
        (yield [__DIR__ . '/Fixture/FunctionLike/SkipSubtypeRector.php', []]);
        (yield [__DIR__ . '/Fixture/ClassMethod/SkipInterface.php', []]);
        (yield [__DIR__ . '/Fixture/AbstractSkip.php', []]);
    }
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return $this->getRuleFromConfig(\Rector\PHPStanExtensions\Rule\RequireRectorCategoryByGetNodeTypesRule::class, __DIR__ . '/config/configured_rule.neon');
    }
}
