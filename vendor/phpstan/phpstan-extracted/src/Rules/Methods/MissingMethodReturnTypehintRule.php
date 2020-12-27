<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
final class MissingMethodReturnTypehintRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
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
        $returnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if ($returnType instanceof \PHPStan\Type\MixedType && !$returnType->isExplicitMixed()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has no return typehint specified.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($returnType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() return type has no value type specified in iterable type %s.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($returnType) as [$name, $genericTypeNames]) {
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() return type with generic %s does not specify its types: %s', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
