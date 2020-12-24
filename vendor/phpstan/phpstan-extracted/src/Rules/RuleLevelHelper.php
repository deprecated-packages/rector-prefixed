<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StrictMixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkNullables, bool $checkThisOnly, bool $checkUnionTypes, bool $checkExplicitMixed = \false)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkNullables = $checkNullables;
        $this->checkThisOnly = $checkThisOnly;
        $this->checkUnionTypes = $checkUnionTypes;
        $this->checkExplicitMixed = $checkExplicitMixed;
    }
    public function isThis(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expression) : bool
    {
        return $expression instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && $expression->name === 'this';
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptedType, bool $strictTypes) : bool
    {
        if ($this->checkExplicitMixed && $acceptedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && $acceptedType->isExplicitMixed()) {
            $acceptedType = new \_PhpScoperb75b35f52b74\PHPStan\Type\StrictMixedType();
        }
        if (!$this->checkNullables && !$acceptingType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType && !$acceptedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType && !$acceptedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType) {
            $acceptedType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::removeNull($acceptedType);
        }
        if ($acceptingType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType && !$acceptedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            foreach ($acceptingType->getTypes() as $innerType) {
                if (self::accepts($innerType, $acceptedType, $strictTypes)) {
                    return \true;
                }
            }
            return \false;
        }
        if ($acceptedType->isArray()->yes() && $acceptingType->isArray()->yes() && !$acceptingType->isIterableAtLeastOnce()->yes() && \count(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($acceptedType)) === 0 && \count(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($acceptingType)) === 0) {
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
    public function findTypeToCheck(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $var, string $unknownClassErrorPattern, callable $unionTypeCriteriaCallback) : \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult
    {
        if ($this->checkThisOnly && !$this->isThis($var)) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType(), [], []);
        }
        $type = $scope->getType($var);
        if (!$this->checkNullables && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::removeNull($type);
        }
        if (\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::containsNull($type)) {
            $type = $scope->getType($this->getNullsafeShortcircuitedExpr($var));
        }
        if ($this->checkExplicitMixed && $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType && $type->isExplicitMixed()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(new \_PhpScoperb75b35f52b74\PHPStan\Type\StrictMixedType(), [], []);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType(), [], []);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
            $type = $type->getStaticObjectType();
        }
        $errors = [];
        $directClassNames = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($type);
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
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($unknownClassErrorPattern, $referencedClass))->line($var->getLine())->discoveringSymbolsTip()->build();
        }
        if (\count($errors) > 0 || $hasClassExistsClass) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType(), [], $errors);
        }
        if (!$this->checkUnionTypes) {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType(), [], []);
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
                $newTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$unionTypeCriteriaCallback($innerType)) {
                        continue;
                    }
                    $newTypes[] = $innerType;
                }
                if (\count($newTypes) > 0) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$newTypes), $directClassNames, []);
                }
            }
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Rules\FoundTypeResult($type, $directClassNames, []);
    }
    private function getNullsafeShortcircuitedExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name, $expr->args);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->dim);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\NullsafePropertyFetch) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name);
        }
        return $expr;
    }
}
