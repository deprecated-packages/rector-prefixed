<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ConstructorManipulator
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->nodeFactory = $nodeFactory;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function addStmtToConstructor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression $newExpression) : void
    {
        $constructClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $constructClassMethod->stmts[] = $newExpression;
        } else {
            $constructClassMethod = $this->nodeFactory->createPublicMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
            $constructClassMethod->stmts[] = $newExpression;
            $this->classInsertManipulator->addAsFirstMethod($class, $constructClassMethod);
            $class->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        }
    }
}
