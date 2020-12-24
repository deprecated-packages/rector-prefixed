<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteUtilsCodeQuality\Rector\LNumber;

use _PhpScoperb75b35f52b74\Nette\Utils\DateTime;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteUtilsCodeQuality\Tests\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector\ReplaceTimeNumberWithDateTimeConstantRectorTest
 */
final class ReplaceTimeNumberWithDateTimeConstantRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @noRector
     * @var array<int, string>
     */
    private const NUMBER_TO_CONSTANT_NAME = [\_PhpScoperb75b35f52b74\Nette\Utils\DateTime::HOUR => 'HOUR', \_PhpScoperb75b35f52b74\Nette\Utils\DateTime::DAY => 'DAY', \_PhpScoperb75b35f52b74\Nette\Utils\DateTime::WEEK => 'WEEK', \_PhpScoperb75b35f52b74\Nette\Utils\DateTime::MONTH => 'MONTH', \_PhpScoperb75b35f52b74\Nette\Utils\DateTime::YEAR => 'YEAR'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace time numbers with Nette\\Utils\\DateTime constants', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber::class];
    }
    /**
     * @param LNumber $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $number = $node->value;
        $constantName = self::NUMBER_TO_CONSTANT_NAME[$number] ?? null;
        if ($constantName === null) {
            return null;
        }
        return $this->createClassConstFetch('_PhpScoperb75b35f52b74\\Nette\\Utils\\DateTime', $constantName);
    }
}
