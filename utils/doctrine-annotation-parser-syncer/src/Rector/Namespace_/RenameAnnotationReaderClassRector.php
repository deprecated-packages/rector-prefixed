<?php

declare (strict_types=1);
namespace Rector\Utils\DoctrineAnnotationParserSyncer\Rector\Namespace_;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\Rector\AbstractRector;
use Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class RenameAnnotationReaderClassRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param Namespace_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var Class_|null $firstClass */
        $firstClass = $this->betterNodeFinder->findFirstInstanceOf($node, \PhpParser\Node\Stmt\Class_::class);
        if ($firstClass === null) {
            return null;
        }
        if (!$this->isName($firstClass, '_PhpScoper006a73f0e455\\Doctrine\\Common\\Annotations\\AnnotationReader')) {
            return null;
        }
        $firstClass->name = new \PhpParser\Node\Identifier('ConstantPreservingAnnotationReader');
        $node->name = new \PhpParser\Node\Name('Rector\\DoctrineAnnotationGenerated');
        return $node;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename AnnotationReader to own constant preserving format', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace Doctrine\Common\Annotations;

class AnnotationReader
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace Rector\DoctrineAnnotationGenerated;

class ConstantPreservingAnnotationReader
{
}
CODE_SAMPLE
)]);
    }
}
