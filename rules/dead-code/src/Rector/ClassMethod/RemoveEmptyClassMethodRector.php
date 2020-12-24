<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\ControllerClassMethodManipulator;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveEmptyClassMethodRector\RemoveEmptyClassMethodRectorTest
 */
final class RemoveEmptyClassMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    /**
     * @var ControllerClassMethodManipulator
     */
    private $controllerClassMethodManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\ControllerClassMethodManipulator $controllerClassMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
        $this->controllerClassMethodManipulator = $controllerClassMethodManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove empty method calls not required by parents', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class OrphanClass
{
    public function __construct()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class OrphanClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if ($node->stmts !== null && $node->stmts !== []) {
            return null;
        }
        if ($node->isAbstract()) {
            return null;
        }
        if ($node->isFinal() && !$classLike->isFinal()) {
            return null;
        }
        if ($this->shouldSkipNonFinalNonPrivateClassMethod($classLike, $node)) {
            return null;
        }
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
    private function shouldSkipNonFinalNonPrivateClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($class->isFinal()) {
            return \false;
        }
        if ($this->isName($classMethod, '__*')) {
            return \false;
        }
        if ($classMethod->isProtected()) {
            return \true;
        }
        return $classMethod->isPublic();
    }
    private function shouldSkipClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->classMethodManipulator->isNamedConstructor($classMethod)) {
            return \true;
        }
        if ($this->classMethodManipulator->hasParentMethodOrInterfaceMethod($classMethod)) {
            return \true;
        }
        if ($this->classMethodManipulator->isPropertyPromotion($classMethod)) {
            return \true;
        }
        return $this->controllerClassMethodManipulator->isControllerClassMethodWithBehaviorAnnotation($classMethod);
    }
}
