<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
final class SetUpClassMethodNodeManipulator
{
    /**
     * @var SetUpClassMethodFactory
     */
    private $setUpClassMethodFactory;
    /**
     * @var StmtManipulator
     */
    private $stmtManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory, \_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function decorateOrCreate(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $stmts) : void
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $setUpClassMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_UP);
        if ($setUpClassMethod === null) {
            $setUpClassMethod = $this->setUpClassMethodFactory->createSetUpMethod($stmts);
            $class->stmts = \array_merge([$setUpClassMethod], (array) $class->stmts);
        } else {
            $setUpClassMethod->stmts = \array_merge((array) $setUpClassMethod->stmts, $stmts);
        }
    }
}
