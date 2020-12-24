<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeManipulator\StmtManipulator;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function createSetUpMethod(array $stmts) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $classMethodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
        $classMethodBuilder->makeProtected();
        $classMethodBuilder->addStmt($this->createParentSetUpStaticCall());
        $classMethodBuilder->addStmts($stmts);
        $classMethod = $classMethodBuilder->getNode();
        $this->phpUnitTypeDeclarationDecorator->decorate($classMethod);
        return $classMethod;
    }
    private function createParentSetUpStaticCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->nodeFactory->createStaticCall('parent', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
}
