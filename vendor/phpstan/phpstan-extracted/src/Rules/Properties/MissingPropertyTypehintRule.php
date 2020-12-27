<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertyNode;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
final class MissingPropertyTypehintRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($node->getName());
        $propertyType = $propertyReflection->getReadableType();
        if ($propertyType instanceof \PHPStan\Type\MixedType && !$propertyType->isExplicitMixed()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s has no typehint specified.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($propertyType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s type has no value type specified in iterable type %s.', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $iterableTypeDescription))->tip(\sprintf(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($propertyType) as [$name, $genericTypeNames]) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Property %s::$%s with generic %s does not specify its types: %s', $propertyReflection->getDeclaringClass()->getDisplayName(), $node->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
