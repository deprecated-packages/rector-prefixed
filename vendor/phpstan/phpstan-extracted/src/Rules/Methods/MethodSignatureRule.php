<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Methods;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
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
        return \_PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
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
        $parameters = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $errors = [];
        foreach ($this->collectParentMethods($methodName, $method->getDeclaringClass()) as $parentMethod) {
            $parentVariants = $parentMethod->getVariants();
            if (\count($parentVariants) !== 1) {
                continue;
            }
            $parentParameters = $parentVariants[0];
            if (!$parentParameters instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                continue;
            }
            [$returnTypeCompatibility, $returnType, $parentReturnType] = $this->checkReturnTypeCompatibility($parameters, $parentParameters);
            if ($returnTypeCompatibility->no() || !$returnTypeCompatibility->yes() && $this->reportMaybes) {
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type (%s) of method %s::%s() should be %s with return type (%s) of method %s::%s()', $returnType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $returnTypeCompatibility->no() ? 'compatible' : 'covariant', $parentReturnType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
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
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() should be %s with parameter $%s (%s) of method %s::%s()', $parameterIndex + 1, $parameter->getName(), $parameterType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parameterResult->no() ? 'compatible' : 'contravariant', $parentParameter->getName(), $parentParameterType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
            }
        }
        return $errors;
    }
    /**
     * @param string $methodName
     * @param \PHPStan\Reflection\ClassReflection $class
     * @return \PHPStan\Reflection\MethodReflection[]
     */
    private function collectParentMethods(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $class) : array
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
    private function checkReturnTypeCompatibility(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $currentVariant, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parentVariant) : array
    {
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($currentVariant->getPhpDocReturnType()));
        $parentReturnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($parentVariant->getNativeReturnType(), \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentVariant->getPhpDocReturnType()));
        // Allow adding `void` return type hints when the parent defines no return type
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType && $parentReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return [\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        // We can return anything
        if ($parentReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType) {
            return [\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        return [$parentReturnType->isSuperTypeOf($returnType), \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), $currentVariant->getPhpDocReturnType()), $parentReturnType];
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
            $parameterType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameter->getPhpDocType()));
            $parentParameterType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($parentParameter->getNativeType(), \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentParameter->getPhpDocType()));
            $parameterResults[] = [$parameterType->isSuperTypeOf($parentParameterType), \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), $parameter->getPhpDocType()), $parentParameterType];
        }
        return $parameterResults;
    }
}
