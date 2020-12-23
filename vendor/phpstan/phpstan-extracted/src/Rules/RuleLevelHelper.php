<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BenevolentUnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StaticType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StrictMixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkNullables, bool $checkThisOnly, bool $checkUnionTypes, bool $checkExplicitMixed = \false)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkNullables = $checkNullables;
        $this->checkThisOnly = $checkThisOnly;
        $this->checkUnionTypes = $checkUnionTypes;
        $this->checkExplicitMixed = $checkExplicitMixed;
    }
    public function isThis(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expression) : bool
    {
        return $expression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable && $expression->name === 'this';
    }
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptedType, bool $strictTypes) : bool
    {
        if ($this->checkExplicitMixed && $acceptedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && $acceptedType->isExplicitMixed()) {
            $acceptedType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\StrictMixedType();
        }
        if (!$this->checkNullables && !$acceptingType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType && !$acceptedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType && !$acceptedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\BenevolentUnionType) {
            $acceptedType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull($acceptedType);
        }
        if ($acceptingType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType && !$acceptedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            foreach ($acceptingType->getTypes() as $innerType) {
                if (self::accepts($innerType, $acceptedType, $strictTypes)) {
                    return \true;
                }
            }
            return \false;
        }
        if ($acceptedType->isArray()->yes() && $acceptingType->isArray()->yes() && !$acceptingType->isIterableAtLeastOnce()->yes() && \count(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantArrays($acceptedType)) === 0 && \count(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantArrays($acceptingType)) === 0) {
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
    public function findTypeToCheck(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $var, string $unknownClassErrorPattern, callable $unionTypeCriteriaCallback) : \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult
    {
        if ($this->checkThisOnly && !$this->isThis($var)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType(), [], []);
        }
        $type = $scope->getType($var);
        if (!$this->checkNullables && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull($type);
        }
        if (\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::containsNull($type)) {
            $type = $scope->getType($this->getNullsafeShortcircuitedExpr($var));
        }
        if ($this->checkExplicitMixed && $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType && $type->isExplicitMixed()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(new \_PhpScoper0a2ac50786fa\PHPStan\Type\StrictMixedType(), [], []);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType(), [], []);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
            $type = $type->getStaticObjectType();
        }
        $errors = [];
        $directClassNames = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getDirectClassNames($type);
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
            $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($unknownClassErrorPattern, $referencedClass))->line($var->getLine())->discoveringSymbolsTip()->build();
        }
        if (\count($errors) > 0 || $hasClassExistsClass) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType(), [], $errors);
        }
        if (!$this->checkUnionTypes) {
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType(), [], []);
            }
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
                $newTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$unionTypeCriteriaCallback($innerType)) {
                        continue;
                    }
                    $newTypes[] = $innerType;
                }
                if (\count($newTypes) > 0) {
                    return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$newTypes), $directClassNames, []);
                }
            }
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\FoundTypeResult($type, $directClassNames, []);
    }
    private function getNullsafeShortcircuitedExpr(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->dim);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name);
        }
        return $expr;
    }
}
