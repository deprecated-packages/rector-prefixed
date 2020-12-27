<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParameterReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
final class MissingMethodParameterTypehintRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $methodReflection = $scope->getFunction();
        if (!$methodReflection instanceof \RectorPrefix20201227\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $messages = [];
        foreach (\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getParameters() as $parameterReflection) {
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
    private function checkMethodParameter(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \RectorPrefix20201227\PHPStan\Reflection\ParameterReflection $parameterReflection) : array
    {
        $parameterType = $parameterReflection->getType();
        if ($parameterType instanceof \PHPStan\Type\MixedType && !$parameterType->isExplicitMixed()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no typehint specified.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($parameterType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no value type specified in iterable type %s.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($parameterType) as [$name, $genericTypeNames]) {
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with generic %s but does not specify its types: %s', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
