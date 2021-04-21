<?php

declare(strict_types=1);

namespace Rector\DeadCode\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\PhpDoc\DeadParamTagValueNodeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector\RemoveUselessParamTagRectorTest
 */
final class RemoveUselessParamTagRector extends AbstractRector
{
    /**
     * @var DeadParamTagValueNodeAnalyzer
     */
    private $deadParamTagValueNodeAnalyzer;

    /**
     * @var PhpDocTagRemover
     */
    private $phpDocTagRemover;

    public function __construct(
        DeadParamTagValueNodeAnalyzer $deadParamTagValueNodeAnalyzer,
        PhpDocTagRemover $phpDocTagRemover
    ) {
        $this->deadParamTagValueNodeAnalyzer = $deadParamTagValueNodeAnalyzer;
        $this->phpDocTagRemover = $phpDocTagRemover;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove @param docblock with same type as parameter type',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $a
     * @param string $b description
     */
    public function foo(string $a, string $b)
    {
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $b description
     */
    public function foo(string $a, string $b)
    {
    }
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);

        foreach ($phpDocInfo->getParamTagValueNodes() as $paramTagValueNode) {
            if (! $this->deadParamTagValueNodeAnalyzer->isDead($paramTagValueNode, $node)) {
                continue;
            }

            $this->phpDocTagRemover->removeTagValueFromNode($phpDocInfo, $paramTagValueNode);
        }

        if ($phpDocInfo->hasChanged()) {
            $this->file->addRectorClassWithLine(new RectorWithLineChange($this, $node->getLine()));
            return $node;
        }

        return null;
    }
}
