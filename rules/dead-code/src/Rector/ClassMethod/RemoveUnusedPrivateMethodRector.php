<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveUnusedPrivateMethodRector\RemoveUnusedPrivateMethodRectorTest
 */
final class RemoveUnusedPrivateMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused private method', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function run()
    {
        return 5;
    }

    private function skip()
    {
        return 10;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $calls = $this->nodeRepository->findCallsByClassMethod($node);
        if ($calls !== []) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Class_|Interface_|Trait_|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        // unreliable to detect trait, interface doesn't make sense
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_ || $classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_) {
            return \true;
        }
        if ($this->isAnonymousClass($classLike)) {
            return \true;
        }
        // skips interfaces by default too
        if (!$classMethod->isPrivate()) {
            return \true;
        }
        // skip magic methods - @see https://www.php.net/manual/en/language.oop5.magic.php
        return $this->isName($classMethod, '__*');
    }
}
