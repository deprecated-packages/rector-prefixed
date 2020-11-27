<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Tests\Rule\ConfigurableRectorRule;

use Iterator;
use PHPStan\Rules\Rule;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\PHPStanExtensions\Rule\ConfigurableRectorRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;
final class ConfigurableRectorRuleTest extends \Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase
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
        (yield [__DIR__ . '/Fixture/ImplementsAndHasConfiguredCodeSampleRector.php', []]);
        (yield [__DIR__ . '/Fixture/ImplementsAndHasNoConfiguredCodeSampleRector.php', [[\Rector\PHPStanExtensions\Rule\ConfigurableRectorRule::ERROR_NO_CONFIGURED_CODE_SAMPLE, 13]]]);
        $notImplementErrorMessage = \sprintf(\Rector\PHPStanExtensions\Rule\ConfigurableRectorRule::ERROR_NOT_IMPLEMENTS_INTERFACE, \Rector\Core\Contract\Rector\ConfigurableRectorInterface::class);
        (yield [__DIR__ . '/Fixture/NotImplementsAndHasConfiguredCodeSampleRector.php', [[$notImplementErrorMessage, 12]]]);
        (yield [__DIR__ . '/Fixture/NotImplementsAndHasNoConfiguredCodeSampleRector.php', []]);
        (yield [__DIR__ . '/Fixture/ImplementsThroughAbstractClassRector.php', []]);
        (yield [__DIR__ . '/Fixture/SkipClassNamesWithoutRectorSuffix.php', []]);
        (yield [__DIR__ . '/Fixture/SkipAbstractRector.php', []]);
    }
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return $this->getRuleFromConfig(\Rector\PHPStanExtensions\Rule\ConfigurableRectorRule::class, __DIR__ . '/config/configured_rule.neon');
    }
}
