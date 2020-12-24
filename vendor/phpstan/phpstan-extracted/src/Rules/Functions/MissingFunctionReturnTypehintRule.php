<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InFunctionNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
final class MissingFunctionReturnTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$returnType->isExplicitMixed()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() has no return typehint specified.', $functionReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($returnType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() return type has no value type specified in iterable type %s.', $functionReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($returnType) as [$name, $genericTypeNames]) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() return type with generic %s does not specify its types: %s', $functionReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
