<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
final class AssignToPropertyTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\ConstructorAssignDetector $constructorAssignDetector, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\PropertyDefaultAssignDetector $propertyDefaultAssignDetector, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\NullTypeAssignDetector $nullTypeAssignDetector)
    {
        $this->constructorAssignDetector = $constructorAssignDetector;
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->propertyDefaultAssignDetector = $propertyDefaultAssignDetector;
        $this->nullTypeAssignDetector = $nullTypeAssignDetector;
    }
    public function inferPropertyInClassLike(string $propertyName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $assignedExprTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName, &$assignedExprTypes) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
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
            $assignedExprTypes[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($assignedExprTypes);
    }
    private function resolveExprStaticTypeIncludingDimFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $exprStaticType = $this->nodeTypeResolver->getStaticType($assign->expr);
        if ($exprStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        if ($assign->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $exprStaticType);
        }
        return $exprStaticType;
    }
    /**
     * @param Type[] $assignedExprTypes
     */
    private function shouldAddNullType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName, array $assignedExprTypes) : bool
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
