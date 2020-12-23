<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
/**
 * Very dummy, use carefully and extend if needed
 */
final class PrefixingClassLikeNamesNodeVisitor extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return null;
    }
    private function refactorClassLike(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike
    {
        if ($classLike->name === null) {
            return null;
        }
        // rename extends
        if ($classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            $this->refactorClass($classLike);
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $classLike->name->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $classLike->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($classLikeName . '_' . $this->suffix);
            return $classLike;
        }
        return null;
    }
    private function refactorNew(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_
    {
        if (!$new->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return null;
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $new->class->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $new->class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($classLikeName . '_' . $this->suffix);
            return $new;
        }
        return null;
    }
    private function refactorClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        if ($class->extends === null) {
            return;
        }
        $extends = $class->extends->toString();
        foreach ($this->classLikeNames as $classLikeName) {
            if ($extends !== $classLikeName) {
                continue;
            }
            $class->extends = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($extends . '_' . $this->suffix);
            break;
        }
    }
}
