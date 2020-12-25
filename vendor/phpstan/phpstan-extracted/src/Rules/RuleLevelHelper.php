<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\CompoundType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StrictMixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
class RuleLevelHelper
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $checkNullables;
    /** @var bool */
    private $checkThisOnly;
    /** @var bool */
    private $checkUnionTypes;
    /** @var bool */
    private $checkExplicitMixed;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkNullables, bool $checkThisOnly, bool $checkUnionTypes, bool $checkExplicitMixed = \false)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkNullables = $checkNullables;
        $this->checkThisOnly = $checkThisOnly;
        $this->checkUnionTypes = $checkUnionTypes;
        $this->checkExplicitMixed = $checkExplicitMixed;
    }
    public function isThis(\PhpParser\Node\Expr $expression) : bool
    {
        return $expression instanceof \PhpParser\Node\Expr\Variable && $expression->name === 'this';
    }
    public function accepts(\PHPStan\Type\Type $acceptingType, \PHPStan\Type\Type $acceptedType, bool $strictTypes) : bool
    {
        if ($this->checkExplicitMixed && $acceptedType instanceof \PHPStan\Type\MixedType && $acceptedType->isExplicitMixed()) {
            $acceptedType = new \PHPStan\Type\StrictMixedType();
        }
        if (!$this->checkNullables && !$acceptingType instanceof \PHPStan\Type\NullType && !$acceptedType instanceof \PHPStan\Type\NullType && !$acceptedType instanceof \PHPStan\Type\BenevolentUnionType) {
            $acceptedType = \PHPStan\Type\TypeCombinator::removeNull($acceptedType);
        }
        if ($acceptingType instanceof \PHPStan\Type\UnionType && !$acceptedType instanceof \PHPStan\Type\CompoundType) {
            foreach ($acceptingType->getTypes() as $innerType) {
                if (self::accepts($innerType, $acceptedType, $strictTypes)) {
                    return \true;
                }
            }
            return \false;
        }
        if ($acceptedType->isArray()->yes() && $acceptingType->isArray()->yes() && !$acceptingType->isIterableAtLeastOnce()->yes() && \count(\PHPStan\Type\TypeUtils::getConstantArrays($acceptedType)) === 0 && \count(\PHPStan\Type\TypeUtils::getConstantArrays($acceptingType)) === 0) {
            return self::accepts($acceptingType->getIterableKeyType(), $acceptedType->getIterableKeyType(), $strictTypes) && self::accepts($acceptingType->getIterableValueType(), $acceptedType->getIterableValueType(), $strictTypes);
        }
        $accepts = $acceptingType->accepts($acceptedType, $strictTypes);
        return $this->checkUnionTypes ? $accepts->yes() : !$accepts->no();
    }
    /**
     * @param Scope $scope
     * @param Expr $var
     * @param string $unknownClassErrorPattern
     * @param callable(Type $type): bool $unionTypeCriteriaCallback
     * @return FoundTypeResult
     */
    public function findTypeToCheck(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr $var, string $unknownClassErrorPattern, callable $unionTypeCriteriaCallback) : \PHPStan\Rules\FoundTypeResult
    {
        if ($this->checkThisOnly && !$this->isThis($var)) {
            return new \PHPStan\Rules\FoundTypeResult(new \PHPStan\Type\ErrorType(), [], []);
        }
        $type = $scope->getType($var);
        if (!$this->checkNullables && !$type instanceof \PHPStan\Type\NullType) {
            $type = \PHPStan\Type\TypeCombinator::removeNull($type);
        }
        if (\PHPStan\Type\TypeCombinator::containsNull($type)) {
            $type = $scope->getType($this->getNullsafeShortcircuitedExpr($var));
        }
        if ($this->checkExplicitMixed && $type instanceof \PHPStan\Type\MixedType && !$type instanceof \PHPStan\Type\Generic\TemplateMixedType && $type->isExplicitMixed()) {
            return new \PHPStan\Rules\FoundTypeResult(new \PHPStan\Type\StrictMixedType(), [], []);
        }
        if ($type instanceof \PHPStan\Type\MixedType || $type instanceof \PHPStan\Type\NeverType) {
            return new \PHPStan\Rules\FoundTypeResult(new \PHPStan\Type\ErrorType(), [], []);
        }
        if ($type instanceof \PHPStan\Type\StaticType) {
            $type = $type->getStaticObjectType();
        }
        $errors = [];
        $directClassNames = \PHPStan\Type\TypeUtils::getDirectClassNames($type);
        $hasClassExistsClass = \false;
        foreach ($directClassNames as $referencedClass) {
            if ($this->reflectionProvider->hasClass($referencedClass)) {
                $classReflection = $this->reflectionProvider->getClass($referencedClass);
                if (!$classReflection->isTrait()) {
                    continue;
                }
            }
            if ($scope->isInClassExists($referencedClass)) {
                $hasClassExistsClass = \true;
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($unknownClassErrorPattern, $referencedClass))->line($var->getLine())->discoveringSymbolsTip()->build();
        }
        if (\count($errors) > 0 || $hasClassExistsClass) {
            return new \PHPStan\Rules\FoundTypeResult(new \PHPStan\Type\ErrorType(), [], $errors);
        }
        if (!$this->checkUnionTypes) {
            if ($type instanceof \PHPStan\Type\ObjectWithoutClassType) {
                return new \PHPStan\Rules\FoundTypeResult(new \PHPStan\Type\ErrorType(), [], []);
            }
            if ($type instanceof \PHPStan\Type\UnionType) {
                $newTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$unionTypeCriteriaCallback($innerType)) {
                        continue;
                    }
                    $newTypes[] = $innerType;
                }
                if (\count($newTypes) > 0) {
                    return new \PHPStan\Rules\FoundTypeResult(\PHPStan\Type\TypeCombinator::union(...$newTypes), $directClassNames, []);
                }
            }
        }
        return new \PHPStan\Rules\FoundTypeResult($type, $directClassNames, []);
    }
    private function getNullsafeShortcircuitedExpr(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr
    {
        if ($expr instanceof \PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \PhpParser\Node\Expr\MethodCall) {
            return new \PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \PhpParser\Node\Expr\StaticCall && $expr->class instanceof \PhpParser\Node\Expr) {
            return new \PhpParser\Node\Expr\StaticCall($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name, $expr->args);
        }
        if ($expr instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return new \PhpParser\Node\Expr\ArrayDimFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->dim);
        }
        if ($expr instanceof \PhpParser\Node\Expr\NullsafePropertyFetch) {
            return new \PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return new \PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \PhpParser\Node\Expr) {
            return new \PhpParser\Node\Expr\StaticPropertyFetch($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name);
        }
        return $expr;
    }
}
