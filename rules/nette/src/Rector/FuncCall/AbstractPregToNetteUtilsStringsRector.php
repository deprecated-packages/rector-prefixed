<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\Contract\PregToNetteUtilsStringInterface;
/**
 * @see https://tomasvotruba.com/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector\PregMatchFunctionToNetteUtilsStringsRectorTest
 */
abstract class AbstractPregToNetteUtilsStringsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Nette\Contract\PregToNetteUtilsStringInterface
{
    /**
     * @param FuncCall|Identical $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($node);
        }
        return $this->refactorFuncCall($node);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class, \PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param array<string, string> $functionRenameMap
     */
    protected function matchFuncCallRenameToMethod(\PhpParser\Node\Expr\FuncCall $funcCall, array $functionRenameMap) : ?string
    {
        $oldFunctionNames = \array_keys($functionRenameMap);
        if (!$this->isNames($funcCall, $oldFunctionNames)) {
            return null;
        }
        $currentFunctionName = $this->getName($funcCall);
        return $functionRenameMap[$currentFunctionName];
    }
    /**
     * @param Expr $expr
     */
    protected function createBoolCast(?\PhpParser\Node $node, \PhpParser\Node $expr) : \PhpParser\Node\Expr\Cast\Bool_
    {
        if ($node instanceof \PhpParser\Node\Stmt\Return_ && $expr instanceof \PhpParser\Node\Expr\Assign) {
            $expr = $expr->expr;
        }
        return new \PhpParser\Node\Expr\Cast\Bool_($expr);
    }
}
