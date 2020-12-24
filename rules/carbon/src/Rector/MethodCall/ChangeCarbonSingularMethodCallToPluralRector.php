<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://carbon.nesbot.com/docs/#api-carbon-2
 *
 * @see \Rector\Carbon\Tests\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector\ChangeCarbonSingularMethodCallToPluralRectorTest
 */
final class ChangeCarbonSingularMethodCallToPluralRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const SINGULAR_TO_PLURAL_NAMES = ['addSecond' => 'addSeconds', 'subSecond' => 'subSeconds', 'addMinute' => 'addMinutes', 'subMinute' => 'subMinutes', 'addDay' => 'addDays', 'subDay' => 'subDays', 'addHour' => 'addHours', 'subHour' => 'subHours', 'addWeek' => 'addWeeks', 'subWeek' => 'subWeeks', 'addMonth' => 'addMonths', 'subMonth' => 'subMonths', 'addYear' => 'addYears', 'subYear' => 'subYears'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper0a6b37af0871\\Change setter methods with args to their plural names on Carbon\\Carbon', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Carbon\Carbon;

final class SomeClass
{
    public function run(Carbon $carbon, $value): void
    {
        $carbon->addMinute($value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Carbon\Carbon;

final class SomeClass
{
    public function run(Carbon $carbon, $value): void
    {
        $carbon->addMinutes($value);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ((array) $node->args === []) {
            return null;
        }
        foreach (self::SINGULAR_TO_PLURAL_NAMES as $singularName => $pluralName) {
            if (!$this->isName($node->name, $singularName)) {
                continue;
            }
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($pluralName);
            return $node;
        }
        return null;
    }
}
