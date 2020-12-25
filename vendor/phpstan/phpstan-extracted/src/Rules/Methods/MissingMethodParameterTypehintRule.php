<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassMethodNode;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
final class MissingMethodParameterTypehintRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $methodReflection = $scope->getFunction();
        if (!$methodReflection instanceof \PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $messages = [];
        foreach (\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getParameters() as $parameterReflection) {
            foreach ($this->checkMethodParameter($methodReflection, $parameterReflection) as $parameterMessage) {
                $messages[] = $parameterMessage;
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Reflection\MethodReflection $methodReflection
     * @param \PHPStan\Reflection\ParameterReflection $parameterReflection
     * @return \PHPStan\Rules\RuleError[]
     */
    private function checkMethodParameter(\PHPStan\Reflection\MethodReflection $methodReflection, \PHPStan\Reflection\ParameterReflection $parameterReflection) : array
    {
        $parameterType = $parameterReflection->getType();
        if ($parameterType instanceof \PHPStan\Type\MixedType && !$parameterType->isExplicitMixed()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no typehint specified.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($parameterType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no value type specified in iterable type %s.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($parameterType) as [$name, $genericTypeNames]) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with generic %s but does not specify its types: %s', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
