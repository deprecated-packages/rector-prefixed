<?php

declare (strict_types=1);
namespace Rector\PHPUnit\NodeFactory;

use PhpParser\Node\Expr;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\MethodName;
use Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use Rector\PHPUnit\NodeManipulator\StmtManipulator;
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
    public function __construct(\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function createSetUpMethod(array $stmts) : \PhpParser\Node\Stmt\ClassMethod
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $classMethodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder(\Rector\Core\ValueObject\MethodName::SET_UP);
        $classMethodBuilder->makeProtected();
        $classMethodBuilder->addStmt($this->createParentSetUpStaticCall());
        $classMethodBuilder->addStmts($stmts);
        $classMethod = $classMethodBuilder->getNode();
        $this->phpUnitTypeDeclarationDecorator->decorate($classMethod);
        return $classMethod;
    }
    private function createParentSetUpStaticCall() : \PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->nodeFactory->createStaticCall('parent', \Rector\Core\ValueObject\MethodName::SET_UP);
        return new \PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
}
