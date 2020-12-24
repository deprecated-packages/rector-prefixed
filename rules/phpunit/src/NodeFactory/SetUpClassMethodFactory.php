<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator\StmtManipulator;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function createSetUpMethod(array $stmts) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $classMethodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_UP);
        $classMethodBuilder->makeProtected();
        $classMethodBuilder->addStmt($this->createParentSetUpStaticCall());
        $classMethodBuilder->addStmts($stmts);
        $classMethod = $classMethodBuilder->getNode();
        $this->phpUnitTypeDeclarationDecorator->decorate($classMethod);
        return $classMethod;
    }
    private function createParentSetUpStaticCall() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression
    {
        $parentSetupStaticCall = $this->nodeFactory->createStaticCall('parent', \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_UP);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($parentSetupStaticCall);
    }
}
