<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypehintHelper;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
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
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
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
        $parameters = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $errors = [];
        foreach ($this->collectParentMethods($methodName, $method->getDeclaringClass()) as $parentMethod) {
            $parentVariants = $parentMethod->getVariants();
            if (\count($parentVariants) !== 1) {
                continue;
            }
            $parentParameters = $parentVariants[0];
            if (!$parentParameters instanceof \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                continue;
            }
            [$returnTypeCompatibility, $returnType, $parentReturnType] = $this->checkReturnTypeCompatibility($parameters, $parentParameters);
            if ($returnTypeCompatibility->no() || !$returnTypeCompatibility->yes() && $this->reportMaybes) {
                $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type (%s) of method %s::%s() should be %s with return type (%s) of method %s::%s()', $returnType->describe(\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $returnTypeCompatibility->no() ? 'compatible' : 'covariant', $parentReturnType->describe(\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
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
                $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() should be %s with parameter $%s (%s) of method %s::%s()', $parameterIndex + 1, $parameter->getName(), $parameterType->describe(\PHPStan\Type\VerbosityLevel::value()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parameterResult->no() ? 'compatible' : 'contravariant', $parentParameter->getName(), $parentParameterType->describe(\PHPStan\Type\VerbosityLevel::value()), $parentMethod->getDeclaringClass()->getDisplayName(), $parentMethod->getName()))->build();
            }
        }
        return $errors;
    }
    /**
     * @param string $methodName
     * @param \PHPStan\Reflection\ClassReflection $class
     * @return \PHPStan\Reflection\MethodReflection[]
     */
    private function collectParentMethods(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassReflection $class) : array
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
    private function checkReturnTypeCompatibility(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $currentVariant, \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parentVariant) : array
    {
        $returnType = \PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($currentVariant->getPhpDocReturnType()));
        $parentReturnType = \PHPStan\Type\TypehintHelper::decideType($parentVariant->getNativeReturnType(), \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentVariant->getPhpDocReturnType()));
        // Allow adding `void` return type hints when the parent defines no return type
        if ($returnType instanceof \PHPStan\Type\VoidType && $parentReturnType instanceof \PHPStan\Type\MixedType) {
            return [\RectorPrefix20201227\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        // We can return anything
        if ($parentReturnType instanceof \PHPStan\Type\VoidType) {
            return [\RectorPrefix20201227\PHPStan\TrinaryLogic::createYes(), $returnType, $parentReturnType];
        }
        return [$parentReturnType->isSuperTypeOf($returnType), \PHPStan\Type\TypehintHelper::decideType($currentVariant->getNativeReturnType(), $currentVariant->getPhpDocReturnType()), $parentReturnType];
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
            $parameterType = \PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameter->getPhpDocType()));
            $parentParameterType = \PHPStan\Type\TypehintHelper::decideType($parentParameter->getNativeType(), \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parentParameter->getPhpDocType()));
            $parameterResults[] = [$parameterType->isSuperTypeOf($parentParameterType), \PHPStan\Type\TypehintHelper::decideType($parameter->getNativeType(), $parameter->getPhpDocType()), $parentParameterType];
        }
        return $parameterResults;
    }
}
