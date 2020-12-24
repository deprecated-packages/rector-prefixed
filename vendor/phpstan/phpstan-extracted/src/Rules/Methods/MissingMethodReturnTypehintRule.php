<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Methods;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
final class MissingMethodReturnTypehintRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\MissingTypehintCheck */
    private $missingTypehintCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck)
    {
        $this->missingTypehintCheck = $missingTypehintCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $methodReflection = $scope->getFunction();
        if (!$methodReflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && !$returnType->isExplicitMixed()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has no return typehint specified.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($returnType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() return type has no value type specified in iterable type %s.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($returnType) as [$name, $genericTypeNames]) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() return type with generic %s does not specify its types: %s', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
