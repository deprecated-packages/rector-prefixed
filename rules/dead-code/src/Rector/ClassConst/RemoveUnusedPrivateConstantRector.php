<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\ClassConst;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassConstManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassConst\RemoveUnusedPrivateConstantRector\RemoveUnusedPrivateConstantRectorTest
 */
final class RemoveUnusedPrivateConstantRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassConstManipulator
     */
    private $classConstManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassConstManipulator $classConstManipulator)
    {
        $this->classConstManipulator = $classConstManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused private constant', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    private const SOME_CONSTANT = 5;
    public function run()
    {
        return 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function run()
    {
        return 5;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->isPrivate()) {
            return null;
        }
        if (\count((array) $node->consts) !== 1) {
            return null;
        }
        // never used
        $classConstFetches = $this->classConstManipulator->getAllClassConstFetch($node);
        if ($classConstFetches !== []) {
            return null;
        }
        // skip enum
        if ($this->classConstManipulator->isEnum($node)) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
}
