<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ClassPropertyNode;
use _PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
final class MissingPropertyTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($node->getName());
        $propertyType = $propertyReflection->getReadableType();
        if ($propertyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$propertyType->isExplicitMixed()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s has no typehint specified.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($propertyType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s type has no value type specified in iterable type %s.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $iterableTypeDescription))->tip(\sprintf(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($propertyType) as [$name, $genericTypeNames]) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s with generic %s does not specify its types: %s', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
