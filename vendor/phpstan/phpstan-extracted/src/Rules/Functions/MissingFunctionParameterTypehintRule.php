<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InFunctionNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
final class MissingFunctionParameterTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReflection = $scope->getFunction();
        if (!$functionReflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $messages = [];
        foreach (\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getParameters() as $parameterReflection) {
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
    private function checkFunctionParameter(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflection $parameterReflection) : array
    {
        $parameterType = $parameterReflection->getType();
        if ($parameterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$parameterType->isExplicitMixed()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with no typehint specified.', $functionReflection->getName(), $parameterReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($parameterType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with no value type specified in iterable type %s.', $functionReflection->getName(), $parameterReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($parameterType) as [$name, $genericTypeNames]) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has parameter $%s with generic %s but does not specify its types: %s', $functionReflection->getName(), $parameterReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
