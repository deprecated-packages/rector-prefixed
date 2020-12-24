<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteUtilsCodeQuality\Rector\LNumber;

use _PhpScopere8e811afab72\Nette\Utils\DateTime;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteUtilsCodeQuality\Tests\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector\ReplaceTimeNumberWithDateTimeConstantRectorTest
 */
final class ReplaceTimeNumberWithDateTimeConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @noRector
     * @var array<int, string>
     */
    private const NUMBER_TO_CONSTANT_NAME = [\_PhpScopere8e811afab72\Nette\Utils\DateTime::HOUR => 'HOUR', \_PhpScopere8e811afab72\Nette\Utils\DateTime::DAY => 'DAY', \_PhpScopere8e811afab72\Nette\Utils\DateTime::WEEK => 'WEEK', \_PhpScopere8e811afab72\Nette\Utils\DateTime::MONTH => 'MONTH', \_PhpScopere8e811afab72\Nette\Utils\DateTime::YEAR => 'YEAR'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace time numbers with Nette\\Utils\\DateTime constants', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        return 86400;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        return \Nette\Utils\DateTime::DAY;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber::class];
    }
    /**
     * @param LNumber $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $number = $node->value;
        $constantName = self::NUMBER_TO_CONSTANT_NAME[$number] ?? null;
        if ($constantName === null) {
            return null;
        }
        return $this->createClassConstFetch('_PhpScopere8e811afab72\\Nette\\Utils\\DateTime', $constantName);
    }
}
