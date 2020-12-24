<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory, \_PhpScopere8e811afab72\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function decorateOrCreate(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, array $stmts) : void
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $setUpClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP);
        if ($setUpClassMethod === null) {
            $setUpClassMethod = $this->setUpClassMethodFactory->createSetUpMethod($stmts);
            $class->stmts = \array_merge([$setUpClassMethod], (array) $class->stmts);
        } else {
            $setUpClassMethod->stmts = \array_merge((array) $setUpClassMethod->stmts, $stmts);
        }
    }
}
