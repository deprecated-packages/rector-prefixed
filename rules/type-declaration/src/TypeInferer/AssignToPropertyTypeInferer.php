<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector;
use Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector;
use Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector;
use Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
final class AssignToPropertyTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer
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
    public function __construct(\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector $constructorAssignDetector, \Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector $propertyDefaultAssignDetector, \Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector $nullTypeAssignDetector)
    {
        $this->constructorAssignDetector = $constructorAssignDetector;
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->propertyDefaultAssignDetector = $propertyDefaultAssignDetector;
        $this->nullTypeAssignDetector = $nullTypeAssignDetector;
    }
    public function inferPropertyInClassLike(string $propertyName, \PhpParser\Node\Stmt\ClassLike $classLike) : \PHPStan\Type\Type
    {
        $assignedExprTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\PhpParser\Node $node) use($propertyName, &$assignedExprTypes) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
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
            $assignedExprTypes[] = new \PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($assignedExprTypes);
    }
    private function resolveExprStaticTypeIncludingDimFetch(\PhpParser\Node\Expr\Assign $assign) : ?\PHPStan\Type\Type
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($assign->expr);
        if ($exprStaticType instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        if ($assign->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $exprStaticType);
        }
        return $exprStaticType;
    }
    /**
     * @param Type[] $assignedExprTypes
     */
    private function shouldAddNullType(\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName, array $assignedExprTypes) : bool
    {
        $hasPropertyDefaultValue = $this->propertyDefaultAssignDetector->detect($classLike, $propertyName);
        $isAssignedInConstructor = $this->constructorAssignDetector->detect($classLike, $propertyName);
        $shouldAddNullType = $this->nullTypeAssignDetector->detect($classLike, $propertyName);
        if ($assignedExprTypes === [] && ($isAssignedInConstructor || $hasPropertyDefaultValue)) {
            return \false;
        }
        if ($shouldAddNullType === \true) {
            return !$isAssignedInConstructor && !$hasPropertyDefaultValue;
        }
        return $assignedExprTypes !== [] && (!$isAssignedInConstructor && !$hasPropertyDefaultValue);
    }
}
