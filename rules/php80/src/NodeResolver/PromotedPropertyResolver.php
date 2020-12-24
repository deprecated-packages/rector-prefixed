<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\NodeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\PropertyPromotionCandidate;
final class PromotedPropertyResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return PropertyPromotionCandidate[]
     */
    public function resolveFromClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return [];
        }
        $propertyPromotionCandidates = [];
        foreach ($class->getProperties() as $property) {
            if (\count((array) $property->props) !== 1) {
                continue;
            }
            $propertyPromotionCandidate = $this->matchPropertyPromotionCandidate($property, $constructClassMethod);
            if ($propertyPromotionCandidate === null) {
                continue;
            }
            $propertyPromotionCandidates[] = $propertyPromotionCandidate;
        }
        return $propertyPromotionCandidates;
    }
    private function matchPropertyPromotionCandidate(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $constructClassMethod) : ?\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\PropertyPromotionCandidate
    {
        $onlyProperty = $property->props[0];
        $propertyName = $this->nodeNameResolver->getName($onlyProperty);
        // match property name to assign in constructor
        foreach ((array) $constructClassMethod->stmts as $stmt) {
            if ($stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                continue;
            }
            $assign = $stmt;
            if (!$this->nodeNameResolver->isLocalPropertyFetchNamed($assign->var, $propertyName)) {
                continue;
            }
            // 1. is param
            // @todo 2. is default value
            $assignedExpr = $assign->expr;
            $matchedParam = $this->matchClassMethodParamByAssignedVariable($constructClassMethod, $assignedExpr);
            if ($matchedParam === null) {
                continue;
            }
            return new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\PropertyPromotionCandidate($property, $assign, $matchedParam);
        }
        return null;
    }
    private function matchClassMethodParamByAssignedVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $assignedExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        foreach ($classMethod->params as $param) {
            if (!$this->betterStandardPrinter->areNodesEqual($assignedExpr, $param->var)) {
                continue;
            }
            return $param;
        }
        return null;
    }
}
