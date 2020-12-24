<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\UnusedNodeResolver\UnusedClassResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedClassesRector\RemoveUnusedClassesRectorTest
 */
final class RemoveUnusedClassesRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var UnusedClassResolver
     */
    private $unusedClassResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadCode\UnusedNodeResolver\UnusedClassResolver $unusedClassResolver)
    {
        $this->unusedClassResolver = $unusedClassResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused classes without interface', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface SomeInterface
{
}

class SomeClass implements SomeInterface
{
    public function run($items)
    {
        return null;
    }
}

class NowhereUsedClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
interface SomeInterface
{
}

class SomeClass implements SomeInterface
{
    public function run($items)
    {
        return null;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        if ($this->unusedClassResolver->isClassUsed($node)) {
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->unusedClassResolver->isClassWithoutInterfaceAndNotController($class)) {
            return \true;
        }
        if ($this->isDoctrineEntityClass($class)) {
            return \true;
        }
        // most of factories can be only registered in config and create services there
        // skip them for now; but in the future, detect types they create in public methods and only keep them, if they're used
        if ($this->isName($class, '*Factory')) {
            return \true;
        }
        return $class->isAbstract();
    }
}
