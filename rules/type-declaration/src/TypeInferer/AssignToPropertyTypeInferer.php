<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
final class AssignToPropertyTypeInferer extends \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector $constructorAssignDetector, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector $propertyDefaultAssignDetector, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector $nullTypeAssignDetector)
    {
        $this->constructorAssignDetector = $constructorAssignDetector;
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->propertyDefaultAssignDetector = $propertyDefaultAssignDetector;
        $this->nullTypeAssignDetector = $nullTypeAssignDetector;
    }
    public function inferPropertyInClassLike(string $propertyName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $assignedExprTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($propertyName, &$assignedExprTypes) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
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
            $assignedExprTypes[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($assignedExprTypes);
    }
    private function resolveExprStaticTypeIncludingDimFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($assign->expr);
        if ($exprStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return null;
        }
        if ($assign->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), $exprStaticType);
        }
        return $exprStaticType;
    }
    /**
     * @param Type[] $assignedExprTypes
     */
    private function shouldAddNullType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName, array $assignedExprTypes) : bool
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
