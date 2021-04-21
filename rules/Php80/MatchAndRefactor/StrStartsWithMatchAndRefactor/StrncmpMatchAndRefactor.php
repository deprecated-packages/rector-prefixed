<?php

declare(strict_types=1);

namespace Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use Rector\Php80\NodeFactory\StrStartsWithFuncCallFactory;
use Rector\Php80\ValueObject\StrStartsWith;
use Rector\Php80\ValueObjectFactory\StrStartsWithFactory;

final class StrncmpMatchAndRefactor implements StrStartWithMatchAndRefactorInterface
{
    /**
     * @var string
     */
    const FUNCTION_NAME = 'strncmp';

    /**
     * @var StrStartsWithFactory
     */
    private $strStartsWithFactory;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var NodeComparator
     */
    private $nodeComparator;

    /**
     * @var StrStartsWithFuncCallFactory
     */
    private $strStartsWithFuncCallFactory;

    public function __construct(
        NodeNameResolver $nodeNameResolver,
        StrStartsWithFactory $strStartsWithFactory,
        NodeComparator $nodeComparator,
        StrStartsWithFuncCallFactory $strStartsWithFuncCallFactory
    ) {
        $this->strStartsWithFactory = $strStartsWithFactory;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeComparator = $nodeComparator;
        $this->strStartsWithFuncCallFactory = $strStartsWithFuncCallFactory;
    }

    /**
     * @param Identical|NotIdentical $binaryOp
     * @return \Rector\Php80\ValueObject\StrStartsWith|null
     */
    public function match(BinaryOp $binaryOp)
    {
        $isPositive = $binaryOp instanceof Identical;

        if ($binaryOp->left instanceof FuncCall && $this->nodeNameResolver->isName(
            $binaryOp->left,
            self::FUNCTION_NAME
        )) {
            return $this->strStartsWithFactory->createFromFuncCall($binaryOp->left, $isPositive);
        }
        if (! $binaryOp->right instanceof FuncCall) {
            return null;
        }
        if (! $this->nodeNameResolver->isName($binaryOp->right, self::FUNCTION_NAME)) {
            return null;
        }
        return $this->strStartsWithFactory->createFromFuncCall($binaryOp->right, $isPositive);
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function refactorStrStartsWith(StrStartsWith $strStartsWith)
    {
        $strncmpFuncCall = $strStartsWith->getFuncCall();
        $needleExpr = $strStartsWith->getNeedleExpr();

        $secondArgumentValue = $strncmpFuncCall->args[2]->value;
        if (! $secondArgumentValue instanceof FuncCall) {
            return null;
        }

        if (! $this->nodeNameResolver->isName($secondArgumentValue, 'strlen')) {
            return null;
        }

        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $strncmpFuncCall->args[2]->value;
        $strlenArgumentValue = $strlenFuncCall->args[0]->value;

        if (! $this->nodeComparator->areNodesEqual($needleExpr, $strlenArgumentValue)) {
            return null;
        }

        return $this->strStartsWithFuncCallFactory->createStrStartsWith($strStartsWith);
    }
}
