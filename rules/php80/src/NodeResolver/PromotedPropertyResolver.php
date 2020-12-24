<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\NodeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\Php80\ValueObject\PropertyPromotionCandidate;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return PropertyPromotionCandidate[]
     */
    public function resolveFromClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $constructClassMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
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
    private function matchPropertyPromotionCandidate(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $constructClassMethod) : ?\_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\PropertyPromotionCandidate
    {
        $onlyProperty = $property->props[0];
        $propertyName = $this->nodeNameResolver->getName($onlyProperty);
        // match property name to assign in constructor
        foreach ((array) $constructClassMethod->stmts as $stmt) {
            if ($stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$stmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
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
            return new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\PropertyPromotionCandidate($property, $assign, $matchedParam);
        }
        return null;
    }
    private function matchClassMethodParamByAssignedVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $assignedExpr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Param
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
