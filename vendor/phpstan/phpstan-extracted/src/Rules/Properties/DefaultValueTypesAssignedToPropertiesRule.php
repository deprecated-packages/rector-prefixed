<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\ClassPropertyNode;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\MixedType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class DefaultValueTypesAssignedToPropertiesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $default = $node->getDefault();
        if ($default === null) {
            return [];
        }
        $propertyReflection = $classReflection->getNativeProperty($node->getName());
        $propertyType = $propertyReflection->getWritableType();
        if ($propertyReflection->getNativeType() instanceof \PHPStan\Type\MixedType) {
            if ($default instanceof \PhpParser\Node\Expr\ConstFetch && (string) $default->name === 'null') {
                return [];
            }
        }
        $defaultValueType = $scope->getType($default);
        if ($this->ruleLevelHelper->accepts($propertyType, $defaultValueType, \true)) {
            return [];
        }
        $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($propertyType);
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s::$%s (%s) does not accept default value of type %s.', $node->isStatic() ? 'Static property' : 'Property', $classReflection->getDisplayName(), $node->getName(), $propertyType->describe($verbosityLevel), $defaultValueType->describe($verbosityLevel)))->build()];
    }
}
