<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
/**
 * Very dummy, use carefully and extend if needed
 */
final class PrefixingClassLikeNamesNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return $this->refactorNew($node);
        }
        return null;
    }
    private function refactorClassLike(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike
    {
        if ($classLike->name === null) {
            return null;
        }
        // rename extends
        if ($classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            $this->refactorClass($classLike);
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $classLike->name->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $classLike->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($classLikeName . '_' . $this->suffix);
            return $classLike;
        }
        return null;
    }
    private function refactorNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_
    {
        if (!$new->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return null;
        }
        foreach ($this->classLikeNames as $classLikeName) {
            $className = $new->class->toString();
            if ($className !== $classLikeName) {
                continue;
            }
            $new->class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($classLikeName . '_' . $this->suffix);
            return $new;
        }
        return null;
    }
    private function refactorClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        if ($class->extends === null) {
            return;
        }
        $extends = $class->extends->toString();
        foreach ($this->classLikeNames as $classLikeName) {
            if ($extends !== $classLikeName) {
                continue;
            }
            $class->extends = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($extends . '_' . $this->suffix);
            break;
        }
    }
}
