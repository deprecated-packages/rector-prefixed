<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\NodeFactory;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Cast\String_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\If_;
use Rector\Core\PhpParser\Node\NodeFactory;
final class StringifyIfFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function createObjetVariableStringCast(string $variableName) : \PhpParser\Node\Stmt\If_
    {
        $variable = new \PhpParser\Node\Expr\Variable($variableName);
        $isObjectFuncCall = $this->nodeFactory->createFuncCall('is_object', [$variable]);
        $if = new \PhpParser\Node\Stmt\If_($isObjectFuncCall);
        $assign = new \PhpParser\Node\Expr\Assign($variable, new \PhpParser\Node\Expr\Cast\String_($variable));
        $if->stmts[] = new \PhpParser\Node\Stmt\Expression($assign);
        return $if;
    }
}
