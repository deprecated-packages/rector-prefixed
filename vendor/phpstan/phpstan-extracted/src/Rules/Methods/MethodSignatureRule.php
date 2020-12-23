<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Methods;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    /** @var bool */
    private $reportStatic;
    public function __construct(bool $reportMaybes, bool $reportStatic)
    {
        $this->reportMaybes = $reportMaybes;
        $this->reportStatic = $reportStatic;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $methodName = $method->getName();
        if ($methodName === '__construct') {
            return [];
        }
        if (!$this->reportStatic && $method->isStatic()) {
            return [];
        }
        if ($method->isPrivate()) {
            return [];
        }
        $parameters = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $errors = [];
        foreach ($this->collectParentMethods($methodName, $method->getDeclaringClass()) as $parentMethod) {
            $parentVariants = $parentMethod->getVariants();
            if (\count($parentVariants) !== 1) {
                continue;
            }
            $parentParameters = $parentVariants[0];
            if (!$parentParameters instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                continue;
            }
            [$returnTypeCompatibility, $returnType, $parentReturnType] = $this->checkReturnTypeCompatibility($parameters, $parentParameters);
            if ($returnTypeCompatibility->no() || !$returnTypeCompatibility->yes() && $this->reportMaybes) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type (%s) of method %s::%s() should be %s with return type (%s) of method %s::%s()', $returnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $returnTypeCompatibility->no() ? 'compatible' : 'covariant', $parentReturnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
            }
            $parameterResults = $this->checkParameterTypeCompatibility($parameters->getParameters(), $parentParameters->getParameters());
            foreach ($parameterResults as $parameterIndex => [$parameterResult, $parameterType, $parentParameterType]) {
                if ($parameterResult->yes()) {
                    continue;
                }
                if (!$parameterResult->no() && !$this->reportMaybes) {
                    continue;
                }
                $parameter = $parameters->getParameters()[$parameterIndex];
                $parentParameter = $parentParameters->getParameters()[$parameterIndex];
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() should be %s with parameter $%s (%s) of method %s::%s()', $parameterIndex + 1, $parameter->getName(), $parameterType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parameterResult->no() ? 'compatible' : 'contravariant', $parentParameter->getName(), $parentParameterType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
            }
        }
        return $errors;
    }
    /**
     * @param string $methodName
     * @param \PHPStan\Reflection\ClassReflection $class
     * @return \PHPStan\Reflection\MethodReflection[]
     */
    private function collectParentMethods(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $class) : array
    {
        $parentMethods = [];
        $parentClass = $class->getParentClass();
        if ($parentClass !== \false && $parentClass->hasNativeMethod($methodName)) {
            $parentMethod = $parentClass->getNativeMethod($methodName);
            if (!$parentMethod->isPrivate()) {
                $parentMethods[] = $parentMethod;
            }
        }
        foreach ($class->getInterfaces() as $interface) {
            if (!$interface->hasNativeMethod($methodName)) {
                continue;
            }
            $parentMethods[] = $interface->getNativeMethod($methodName);
        }
        return $parentMethods;
    }
    /**
     * @param ParametersAcceptorWithPhpDocs $currentVariant
     * @param ParametersAcceptorWithPhpDocs $parentVariant
     * @return array{TrinaryLogic, Type, Type}
     */
    private function checkReturnTypeCompatibility(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $currentVariant, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parentVariant) : array
    {
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($currentVariant->getPhpDocReturnType()));
        $parentReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($parentVariant->getNativeReturnType(), \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentVariant->getPhpDocReturnType()));
        // Allow adding `void` return type hints when the parent defines no return type
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType && $parentReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        // We can return anything
        if ($parentReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        return [$parentReturnType->isSuperTypeOf($returnType), \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), $currentVariant->getPhpDocReturnType()), $parentReturnType];
    }
    /**
     * @param \PHPStan\Reflection\ParameterReflectionWithPhpDocs[] $parameters
     * @param \PHPStan\Reflection\ParameterReflectionWithPhpDocs[] $parentParameters
     * @return array<int, array{TrinaryLogic, Type, Type}>
     */
    private function checkParameterTypeCompatibility(array $parameters, array $parentParameters) : array
    {
        $parameterResults = [];
        $numberOfParameters = \min(\count($parameters), \count($parentParameters));
        for ($i = 0; $i < $numberOfParameters; $i++) {
            $parameter = $parameters[$i];
            $parentParameter = $parentParameters[$i];
            $parameterType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameter->getPhpDocType()));
            $parentParameterType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($parentParameter->getNativeType(), \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentParameter->getPhpDocType()));
            $parameterResults[] = [$parameterType->isSuperTypeOf($parentParameterType), \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), $parameter->getPhpDocType()), $parentParameterType];
        }
        return $parameterResults;
    }
}
