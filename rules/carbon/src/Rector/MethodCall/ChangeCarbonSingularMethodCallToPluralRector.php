<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Carbon\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://carbon.nesbot.com/docs/#api-carbon-2
 *
 * @see \Rector\Carbon\Tests\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector\ChangeCarbonSingularMethodCallToPluralRectorTest
 */
final class ChangeCarbonSingularMethodCallToPluralRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const SINGULAR_TO_PLURAL_NAMES = ['addSecond' => 'addSeconds', 'subSecond' => 'subSeconds', 'addMinute' => 'addMinutes', 'subMinute' => 'subMinutes', 'addDay' => 'addDays', 'subDay' => 'subDays', 'addHour' => 'addHours', 'subHour' => 'subHours', 'addWeek' => 'addWeeks', 'subWeek' => 'subWeeks', 'addMonth' => 'addMonths', 'subMonth' => 'subMonths', 'addYear' => 'addYears', 'subYear' => 'subYears'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoperb75b35f52b74\\Change setter methods with args to their plural names on Carbon\\Carbon', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ((array) $node->args === []) {
            return null;
        }
        foreach (self::SINGULAR_TO_PLURAL_NAMES as $singularName => $pluralName) {
            if (!$this->isName($node->name, $singularName)) {
                continue;
            }
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($pluralName);
            return $node;
        }
        return null;
    }
}
