<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InFunctionNode;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
final class MissingFunctionReturnTypehintRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $functionReflection = $scope->getFunction();
        if (!$functionReflection instanceof \PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($returnType instanceof \PHPStan\Type\MixedType && !$returnType->isExplicitMixed()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has no return typehint specified.', $functionReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($returnType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() return type has no value type specified in iterable type %s.', $functionReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($returnType) as [$name, $genericTypeNames]) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() return type with generic %s does not specify its types: %s', $functionReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
