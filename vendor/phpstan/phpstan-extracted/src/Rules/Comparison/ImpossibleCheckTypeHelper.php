<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Comparison;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class ImpossibleCheckTypeHelper
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    /** @var string[] */
    private $universalObjectCratesClasses;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Analyser\TypeSpecifier $typeSpecifier
     * @param string[] $universalObjectCratesClasses
     * @param bool $treatPhpDocTypesAsCertain
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier, array $universalObjectCratesClasses, bool $treatPhpDocTypesAsCertain)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->typeSpecifier = $typeSpecifier;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function findSpecifiedType(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $node) : ?bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall && \count($node->args) > 0) {
            if ($node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
                $functionName = \strtolower((string) $node->name);
                if ($functionName === 'assert') {
                    $assertValue = $scope->getType($node->args[0]->value)->toBoolean();
                    if (!$assertValue instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) {
                        return null;
                    }
                    return $assertValue->getValue();
                }
                if (\in_array($functionName, ['class_exists', 'interface_exists', 'trait_exists'], \true)) {
                    return null;
                }
                if ($functionName === 'count') {
                    return null;
                } elseif ($functionName === 'defined') {
                    return null;
                } elseif ($functionName === 'in_array' && \count($node->args) >= 3) {
                    $haystackType = $scope->getType($node->args[1]->value);
                    if ($haystackType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                        return null;
                    }
                    if (!$haystackType->isArray()->yes()) {
                        return null;
                    }
                    if (!$haystackType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType || \count($haystackType->getValueTypes()) > 0) {
                        $needleType = $scope->getType($node->args[0]->value);
                        $haystackArrayTypes = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getArrays($haystackType);
                        if (\count($haystackArrayTypes) === 1 && $haystackArrayTypes[0]->getIterableValueType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
                            return null;
                        }
                        $valueType = $haystackType->getIterableValueType();
                        $isNeedleSupertype = $needleType->isSuperTypeOf($valueType);
                        if ($isNeedleSupertype->maybe() || $isNeedleSupertype->yes()) {
                            foreach ($haystackArrayTypes as $haystackArrayType) {
                                foreach (\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($haystackArrayType->getIterableValueType()) as $constantScalarType) {
                                    if ($needleType->isSuperTypeOf($constantScalarType)->yes()) {
                                        continue 2;
                                    }
                                }
                                return null;
                            }
                        }
                        if ($isNeedleSupertype->yes()) {
                            $hasConstantNeedleTypes = \count(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($needleType)) > 0;
                            $hasConstantHaystackTypes = \count(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($valueType)) > 0;
                            if (!$hasConstantNeedleTypes && !$hasConstantHaystackTypes || $hasConstantNeedleTypes !== $hasConstantHaystackTypes) {
                                return null;
                            }
                        }
                    }
                } elseif ($functionName === 'method_exists' && \count($node->args) >= 2) {
                    $objectType = $scope->getType($node->args[0]->value);
                    $methodType = $scope->getType($node->args[1]->value);
                    if ($objectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType && !$this->reflectionProvider->hasClass($objectType->getValue())) {
                        return \false;
                    }
                    if ($methodType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                        if ($objectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($objectType->getValue());
                        }
                        if ($objectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                            if ($objectType->hasMethod($methodType->getValue())->yes()) {
                                return \true;
                            }
                            if ($objectType->hasMethod($methodType->getValue())->no()) {
                                return \false;
                            }
                        }
                    }
                }
            }
        }
        $specifiedTypes = $this->typeSpecifier->specifyTypesInCondition($scope, $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
        $sureTypes = $specifiedTypes->getSureTypes();
        $sureNotTypes = $specifiedTypes->getSureNotTypes();
        $isSpecified = static function (\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) use($scope, $node) : bool {
            return ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) && $scope->isSpecified($expr);
        };
        if (\count($sureTypes) === 1 && \count($sureNotTypes) === 0) {
            $sureType = \reset($sureTypes);
            if ($isSpecified($sureType[0])) {
                return null;
            }
            if ($this->treatPhpDocTypesAsCertain) {
                $argumentType = $scope->getType($sureType[0]);
            } else {
                $argumentType = $scope->getNativeType($sureType[0]);
            }
            /** @var \PHPStan\Type\Type $resultType */
            $resultType = $sureType[1];
            $isSuperType = $resultType->isSuperTypeOf($argumentType);
            if ($isSuperType->yes()) {
                return \true;
            } elseif ($isSuperType->no()) {
                return \false;
            }
            return null;
        } elseif (\count($sureNotTypes) === 1 && \count($sureTypes) === 0) {
            $sureNotType = \reset($sureNotTypes);
            if ($isSpecified($sureNotType[0])) {
                return null;
            }
            if ($this->treatPhpDocTypesAsCertain) {
                $argumentType = $scope->getType($sureNotType[0]);
            } else {
                $argumentType = $scope->getNativeType($sureNotType[0]);
            }
            /** @var \PHPStan\Type\Type $resultType */
            $resultType = $sureNotType[1];
            $isSuperType = $resultType->isSuperTypeOf($argumentType);
            if ($isSuperType->yes()) {
                return \false;
            } elseif ($isSuperType->no()) {
                return \true;
            }
            return null;
        }
        if (\count($sureTypes) > 0) {
            foreach ($sureTypes as $sureType) {
                if ($isSpecified($sureType[0])) {
                    return null;
                }
            }
            $types = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_column($sureTypes, 1));
            if ($types instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
                return \false;
            }
        }
        if (\count($sureNotTypes) > 0) {
            foreach ($sureNotTypes as $sureNotType) {
                if ($isSpecified($sureNotType[0])) {
                    return null;
                }
            }
            $types = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_column($sureNotTypes, 1));
            if ($types instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
                return \true;
            }
        }
        return null;
    }
    /**
     * @param Scope $scope
     * @param \PhpParser\Node\Arg[] $args
     * @return string
     */
    public function getArgumentsDescription(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, array $args) : string
    {
        if (\count($args) === 0) {
            return '';
        }
        $descriptions = \array_map(static function (\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg) use($scope) : string {
            return $scope->getType($arg->value)->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value());
        }, $args);
        if (\count($descriptions) < 3) {
            return \sprintf(' with %s', \implode(' and ', $descriptions));
        }
        $lastDescription = \array_pop($descriptions);
        return \sprintf(' with arguments %s and %s', \implode(', ', $descriptions), $lastDescription);
    }
    public function doNotTreatPhpDocTypesAsCertain() : self
    {
        if (!$this->treatPhpDocTypesAsCertain) {
            return $this;
        }
        return new self($this->reflectionProvider, $this->typeSpecifier, $this->universalObjectCratesClasses, \false);
    }
}
