<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator\StmtManipulator;
final class SetUpClassMethodFactory
{
    /**
     * @var PHPUnitTypeDeclarationDecorator
     */
    private $phpUnitTypeDeclarationDecorator;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var StmtManipulator
     */
    private $stmtManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function createSetUpMethod(array $stmts) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $classMethodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP);
        $classMethodBuilder->makeProtected();
        $classMethodBuilder->addStmt($this->createParentSetUpStaticCall());
        $classMethodBuilder->addStmts($stmts);
        $classMethod = $classMethodBuilder->getNode();
        $this->phpUnitTypeDeclarationDecorator->decorate($classMethod);
        return $classMethod;
    }
    private function createParentSetUpStaticCall() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->nodeFactory->createStaticCall('parent', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
}
