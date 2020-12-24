<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteUtilsCodeQuality\Rector\LNumber;

use _PhpScoper0a6b37af0871\Nette\Utils\DateTime;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteUtilsCodeQuality\Tests\Rector\LNumber\ReplaceTimeNumberWithDateTimeConstantRector\ReplaceTimeNumberWithDateTimeConstantRectorTest
 */
final class ReplaceTimeNumberWithDateTimeConstantRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @noRector
     * @var array<int, string>
     */
    private const NUMBER_TO_CONSTANT_NAME = [\_PhpScoper0a6b37af0871\Nette\Utils\DateTime::HOUR => 'HOUR', \_PhpScoper0a6b37af0871\Nette\Utils\DateTime::DAY => 'DAY', \_PhpScoper0a6b37af0871\Nette\Utils\DateTime::WEEK => 'WEEK', \_PhpScoper0a6b37af0871\Nette\Utils\DateTime::MONTH => 'MONTH', \_PhpScoper0a6b37af0871\Nette\Utils\DateTime::YEAR => 'YEAR'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace time numbers with Nette\\Utils\\DateTime constants', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber::class];
    }
    /**
     * @param LNumber $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $number = $node->value;
        $constantName = self::NUMBER_TO_CONSTANT_NAME[$number] ?? null;
        if ($constantName === null) {
            return null;
        }
        return $this->createClassConstFetch('_PhpScoper0a6b37af0871\\Nette\\Utils\\DateTime', $constantName);
    }
}
