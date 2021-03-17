<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\NodeManipulator\ClassMethodManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\NodeManipulator\ControllerClassMethodManipulator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector\RemoveEmptyClassMethodRectorTest
 */
final class RemoveEmptyClassMethodRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    /**
     * @var ControllerClassMethodManipulator
     */
    private $controllerClassMethodManipulator;
    /**
     * @param \Rector\Core\NodeManipulator\ClassMethodManipulator $classMethodManipulator
     * @param \Rector\DeadCode\NodeManipulator\ControllerClassMethodManipulator $controllerClassMethodManipulator
     */
    public function __construct($classMethodManipulator, $controllerClassMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
        $this->controllerClassMethodManipulator = $controllerClassMethodManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove empty method calls not required by parents', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
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
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkipNonFinalNonPrivateClassMethod($class, $classMethod) : bool
    {
        if ($class->isFinal()) {
            return \false;
        }
        if ($classMethod->isMagic()) {
            return \false;
        }
        if ($classMethod->isProtected()) {
            return \true;
        }
        return $classMethod->isPublic();
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkipClassMethod($classMethod) : bool
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
