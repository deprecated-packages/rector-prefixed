<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory, \_PhpScoperb75b35f52b74\Rector\PHPUnit\NodeManipulator\StmtManipulator $stmtManipulator)
    {
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
        $this->stmtManipulator = $stmtManipulator;
    }
    /**
     * @param Stmt[]|Expr[] $stmts
     */
    public function decorateOrCreate(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $stmts) : void
    {
        $stmts = $this->stmtManipulator->normalizeStmts($stmts);
        $setUpClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
        if ($setUpClassMethod === null) {
            $setUpClassMethod = $this->setUpClassMethodFactory->createSetUpMethod($stmts);
            $class->stmts = \array_merge([$setUpClassMethod], (array) $class->stmts);
        } else {
            $setUpClassMethod->stmts = \array_merge((array) $setUpClassMethod->stmts, $stmts);
        }
    }
}
