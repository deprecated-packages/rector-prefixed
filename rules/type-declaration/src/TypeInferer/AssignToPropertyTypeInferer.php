<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
final class AssignToPropertyTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer
{
    /**
     * @var ConstructorAssignDetector
     */
    private $constructorAssignDetector;
    /**
     * @var PropertyAssignMatcher
     */
    private $propertyAssignMatcher;
    /**
     * @var PropertyDefaultAssignDetector
     */
    private $propertyDefaultAssignDetector;
    /**
     * @var NullTypeAssignDetector
     */
    private $nullTypeAssignDetector;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector $constructorAssignDetector, \_PhpScopere8e811afab72\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector $propertyDefaultAssignDetector, \_PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector $nullTypeAssignDetector)
    {
        $this->constructorAssignDetector = $constructorAssignDetector;
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->propertyDefaultAssignDetector = $propertyDefaultAssignDetector;
        $this->nullTypeAssignDetector = $nullTypeAssignDetector;
    }
    public function inferPropertyInClassLike(string $propertyName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $assignedExprTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$assignedExprTypes) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            $expr = $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            $exprStaticType = $this->resolveExprStaticTypeIncludingDimFetch($node);
            if ($exprStaticType === null) {
                return null;
            }
            $assignedExprTypes[] = $exprStaticType;
            return null;
        });
        if ($this->shouldAddNullType($classLike, $propertyName, $assignedExprTypes)) {
            $assignedExprTypes[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($assignedExprTypes);
    }
    private function resolveExprStaticTypeIncludingDimFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($assign->expr);
        if ($exprStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        if ($assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $exprStaticType);
        }
        return $exprStaticType;
    }
    /**
     * @param Type[] $assignedExprTypes
     */
    private function shouldAddNullType(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName, array $assignedExprTypes) : bool
    {
        $hasPropertyDefaultValue = $this->propertyDefaultAssignDetector->detect($classLike, $propertyName);
        $isAssignedInConstructor = $this->constructorAssignDetector->isPropertyAssigned($classLike, $propertyName);
        $shouldAddNullType = $this->nullTypeAssignDetector->detect($classLike, $propertyName);
        if ($assignedExprTypes === [] && ($isAssignedInConstructor || $hasPropertyDefaultValue)) {
            return \false;
        }
        if ($shouldAddNullType === \true) {
            if ($isAssignedInConstructor) {
                return \false;
            }
            return !$hasPropertyDefaultValue;
        }
        if ($assignedExprTypes === []) {
            return \false;
        }
        if ($isAssignedInConstructor) {
            return \false;
        }
        return !$hasPropertyDefaultValue;
    }
}
