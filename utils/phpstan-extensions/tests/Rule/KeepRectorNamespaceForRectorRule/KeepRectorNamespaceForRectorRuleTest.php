<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Tests\Rule\KeepRectorNamespaceForRectorRule;

use Iterator;
use PHPStan\Rules\Rule;
use Rector\PHPStanExtensions\Rule\KeepRectorNamespaceForRectorRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;
final class KeepRectorNamespaceForRectorRuleTest extends \Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase
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
        (yield [__DIR__ . '/Fixture/Rector/ClassInCorrectNamespaceRector.php', []]);
        $errorMessage = \sprintf(\Rector\PHPStanExtensions\Rule\KeepRectorNamespaceForRectorRule::ERROR_MESSAGE, 'WrongClass');
        (yield [__DIR__ . '/Fixture/Rector/WrongClass.php', [[$errorMessage, 7]]]);
    }
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return $this->getRuleFromConfig(\Rector\PHPStanExtensions\Rule\KeepRectorNamespaceForRectorRule::class, __DIR__ . '/config/configured_rule.neon');
    }
}
