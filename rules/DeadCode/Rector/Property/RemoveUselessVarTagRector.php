<?php

declare(strict_types=1);

namespace Rector\DeadCode\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\ChangesReporting\ValueObject\RectorWithLineChange;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\PhpDoc\TagRemover\VarTagRemover;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DeadCode\Rector\Property\RemoveUselessVarTagRector\RemoveUselessVarTagRectorTest
 */
final class RemoveUselessVarTagRector extends AbstractRector
{
    /**
     * @var VarTagRemover
     */
    private $varTagRemover;

    public function __construct(VarTagRemover $varTagRemover)
    {
        $this->varTagRemover = $varTagRemover;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove unused @var annotation for properties', [
            new CodeSample(
                <<<'CODE_SAMPLE'
final class SomeClass
{
    /**
     * @var string
     */
    public string $name = 'name';
}
CODE_SAMPLE

                ,
                <<<'CODE_SAMPLE'
final class SomeClass
{
    public string $name = 'name';
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
        return [Property::class];
    }

    /**
     * @param Property $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $this->varTagRemover->removeVarTagIfUseless($phpDocInfo, $node);

        if ($phpDocInfo->hasChanged()) {
            $this->file->addRectorClassWithLine(new RectorWithLineChange($this, $node->getLine()));
            return $node;
        }

        return null;
    }
}
