<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
/**
 * Very dummy, use carefully and extend if needed
 */
final class PrefixingClassLikeNamesNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @var string
     */
    private $suffix;
    /**
     * @var string[]
     */
    private $classLikeNames = [];
    /**
     * @param string[] $classLikeNames
     */
    public function __construct(array $classLikeNames, string $suffix)
    {
        $this->classLikeNames = $classLikeNames;
        $this->suffix = $suffix;
    }
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return null;
    }
    private function refactorClassLike(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike
    {
        if ($classLike->name === null) {
            return null;
        }
        // rename extends
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            $this->refactorClass($classLike);
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $classLike->name->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $classLike->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($classLikeName . '_' . $this->suffix);
            return $classLike;
        }
        return null;
    }
    private function refactorNew(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_
    {
        if (!$new->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return null;
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $new->class->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $new->class = new \_PhpScopere8e811afab72\PhpParser\Node\Name($classLikeName . '_' . $this->suffix);
            return $new;
        }
        return null;
    }
    private function refactorClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        if ($class->extends === null) {
            return;
        }
        $extends = $class->extends->toString();
        foreach ($this->classLikeNames as $classLikeName) {
            if ($extends !== $classLikeName) {
                continue;
            }
            $class->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name($extends . '_' . $this->suffix);
            break;
        }
    }
}
