<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InFunctionNode;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
final class MissingFunctionParameterTypehintRule implements \PHPStan\Rules\Rule
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
        $messages = [];
        foreach (\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getParameters() as $parameterReflection) {
            foreach ($this->checkFunctionParameter($functionReflection, $parameterReflection) as $parameterMessage) {
                $messages[] = $parameterMessage;
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Reflection\FunctionReflection $functionReflection
     * @param \PHPStan\Reflection\ParameterReflection $parameterReflection
     * @return \PHPStan\Rules\RuleError[]
     */
    private function checkFunctionParameter(\PHPStan\Reflection\FunctionReflection $functionReflection, \PHPStan\Reflection\ParameterReflection $parameterReflection) : array
    {
        $parameterType = $parameterReflection->getType();
        if ($parameterType instanceof \PHPStan\Type\MixedType && !$parameterType->isExplicitMixed()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with no typehint specified.', $functionReflection->getName(), $parameterReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($parameterType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with no value type specified in iterable type %s.', $functionReflection->getName(), $parameterReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($parameterType) as [$name, $genericTypeNames]) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with generic %s but does not specify its types: %s', $functionReflection->getName(), $parameterReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
