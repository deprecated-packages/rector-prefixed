<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\NodeVisitorAbstract;
/**
 * Very dummy, use carefully and extend if needed
 */
final class PrefixingClassLikeNamesNodeVisitor extends \PhpParser\NodeVisitorAbstract
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
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return null;
    }
    private function refactorClassLike(\PhpParser\Node\Stmt\ClassLike $classLike) : ?\PhpParser\Node\Stmt\ClassLike
    {
        if ($classLike->name === null) {
            return null;
        }
        // rename extends
        if ($classLike instanceof \PhpParser\Node\Stmt\Class_) {
            $this->refactorClass($classLike);
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $classLike->name->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $classLike->name = new \PhpParser\Node\Identifier($classLikeName . '_' . $this->suffix);
            return $classLike;
        }
        return null;
    }
    private function refactorNew(\PhpParser\Node\Expr\New_ $new) : ?\PhpParser\Node\Expr\New_
    {
        if (!$new->class instanceof \PhpParser\Node\Name) {
            return null;
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $new->class->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $new->class = new \PhpParser\Node\Name($classLikeName . '_' . $this->suffix);
            return $new;
        }
        return null;
    }
    private function refactorClass(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        if ($class->extends === null) {
            return;
        }
        $extends = $class->extends->toString();
        foreach ($this->classLikeNames as $classLikeName) {
            if ($extends !== $classLikeName) {
                continue;
            }
            $class->extends = new \PhpParser\Node\Name($extends . '_' . $this->suffix);
            break;
        }
    }
}
