<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
final class AssignToPropertyTypeInferer extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector $constructorAssignDetector, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector $propertyDefaultAssignDetector, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector $nullTypeAssignDetector)
    {
        $this->constructorAssignDetector = $constructorAssignDetector;
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->propertyDefaultAssignDetector = $propertyDefaultAssignDetector;
        $this->nullTypeAssignDetector = $nullTypeAssignDetector;
    }
    public function inferPropertyInClassLike(string $propertyName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $assignedExprTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($propertyName, &$assignedExprTypes) {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
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
            $assignedExprTypes[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($assignedExprTypes);
    }
    private function resolveExprStaticTypeIncludingDimFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($assign->expr);
        if ($exprStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return null;
        }
        if ($assign->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), $exprStaticType);
        }
        return $exprStaticType;
    }
    /**
     * @param Type[] $assignedExprTypes
     */
    private function shouldAddNullType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName, array $assignedExprTypes) : bool
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
