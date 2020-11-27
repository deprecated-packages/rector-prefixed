<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule;

use Iterator;
use PHPStan\Rules\Rule;
use Rector\PHPStanExtensions\Rule\RectorRuleAndValueObjectHaveSameStartsRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;
final class RectorRuleAndValueObjectHaveSameStartsRuleTest extends \Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase
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
        (yield [__DIR__ . '/Fixture/HaveSameStarts.php', []]);
        (yield [__DIR__ . '/Fixture/SkipDifferentType.php', []]);
        (yield [__DIR__ . '/Fixture/SkipNoCall.php', []]);
        (yield [__DIR__ . '/Fixture/SkipNoCallConfigure.php', []]);
        (yield [__DIR__ . '/Fixture/SkipNoInlineValueObjects.php', []]);
        (yield [__DIR__ . '/Fixture/SkipConfigureValueObjectImplementsInterface.php', []]);
        $errorMessage = \sprintf(\Rector\PHPStanExtensions\Rule\RectorRuleAndValueObjectHaveSameStartsRule::ERROR_MESSAGE, 'ConfigureValueObject', 'ChangeMethodVisibility');
        (yield [__DIR__ . '/Fixture/HaveDifferentStarts.php', [[$errorMessage, 15]]]);
    }
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return $this->getRuleFromConfig(\Rector\PHPStanExtensions\Rule\RectorRuleAndValueObjectHaveSameStartsRule::class, __DIR__ . '/config/configured_rule.neon');
    }
}
