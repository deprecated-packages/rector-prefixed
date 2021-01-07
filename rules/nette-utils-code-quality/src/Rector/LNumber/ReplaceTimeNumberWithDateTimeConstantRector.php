<?php

declare (strict_types=1);
namespace Rector\NetteUtilsCodeQuality\Rector\LNumber;

use RectorPrefix20210107\Nette\Utils\DateTime;
use PhpParser\Node;
use PhpParser\Node\Scalar\LNumber;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteUtilsCodeQuality\Tests\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector\ReplaceTimeNumberWithDateTimeConstantRectorTest
 */
final class ReplaceTimeNumberWithDateTimeConstantRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @noRector
     * @var array<int, string>
     */
    private const NUMBER_TO_CONSTANT_NAME = [\RectorPrefix20210107\Nette\Utils\DateTime::HOUR => 'HOUR', \RectorPrefix20210107\Nette\Utils\DateTime::DAY => 'DAY', \RectorPrefix20210107\Nette\Utils\DateTime::WEEK => 'WEEK', \RectorPrefix20210107\Nette\Utils\DateTime::MONTH => 'MONTH', \RectorPrefix20210107\Nette\Utils\DateTime::YEAR => 'YEAR'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace time numbers with Nette\\Utils\\DateTime constants', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Scalar\LNumber::class];
    }
    /**
     * @param LNumber $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $number = $node->value;
        $constantName = self::NUMBER_TO_CONSTANT_NAME[$number] ?? null;
        if ($constantName === null) {
            return null;
        }
        return $this->createClassConstFetch('Nette\\Utils\\DateTime', $constantName);
    }
}
