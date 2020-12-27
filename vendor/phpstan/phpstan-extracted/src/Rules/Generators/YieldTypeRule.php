<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Generators;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Yield_>
 */
class YieldTypeRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Yield_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [];
            // already reported by YieldInGeneratorRule
        }
        if ($returnType instanceof \PHPStan\Type\MixedType) {
            return [];
        }
        if ($node->key === null) {
            $keyType = new \PHPStan\Type\IntegerType();
        } else {
            $keyType = $scope->getType($node->key);
        }
        if ($node->value === null) {
            $valueType = new \PHPStan\Type\NullType();
        } else {
            $valueType = $scope->getType($node->value);
        }
        $messages = [];
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableKeyType(), $keyType, $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableKeyType());
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects key type %s, %s given.', $returnType->getIterableKeyType()->describe($verbosityLevel), $keyType->describe($verbosityLevel)))->build();
        }
        if (!$this->ruleLevelHelper->accepts($returnType->getIterableValueType(), $valueType, $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType->getIterableValueType());
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Generator expects value type %s, %s given.', $returnType->getIterableValueType()->describe($verbosityLevel), $valueType->describe($verbosityLevel)))->build();
        }
        if ($scope->getType($node) instanceof \PHPStan\Type\VoidType && !$scope->isInFirstLevelStatement()) {
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Result of yield (void) is used.')->build();
        }
        return $messages;
    }
}
