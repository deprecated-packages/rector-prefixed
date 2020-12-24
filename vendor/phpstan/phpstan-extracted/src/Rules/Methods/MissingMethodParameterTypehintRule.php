<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Methods;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
final class MissingMethodParameterTypehintRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
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
        $messages = [];
        foreach (\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getParameters() as $parameterReflection) {
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
    private function checkMethodParameter(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection $parameterReflection) : array
    {
        $parameterType = $parameterReflection->getType();
        if ($parameterType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType && !$parameterType->isExplicitMixed()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no typehint specified.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName()))->build()];
        }
        $messages = [];
        foreach ($this->missingTypehintCheck->getIterableTypesWithMissingValueTypehint($parameterType) as $iterableType) {
            $iterableTypeDescription = $iterableType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with no value type specified in iterable type %s.', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $iterableTypeDescription))->tip(\sprintf(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP, $iterableTypeDescription))->build();
        }
        foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($parameterType) as [$name, $genericTypeNames]) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() has parameter $%s with generic %s but does not specify its types: %s', $methodReflection->getDeclaringClass()->getDisplayName(), $methodReflection->getName(), $parameterReflection->getName(), $name, \implode(', ', $genericTypeNames)))->tip(\_PhpScoperb75b35f52b74\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
        }
        return $messages;
    }
}
