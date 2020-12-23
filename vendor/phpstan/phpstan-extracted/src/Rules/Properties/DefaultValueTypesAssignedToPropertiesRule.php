<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\ClassPropertyNode;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class DefaultValueTypesAssignedToPropertiesRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $default = $node->getDefault();
        if ($default === null) {
            return [];
        }
        $propertyReflection = $classReflection->getNativeProperty($node->getName());
        $propertyType = $propertyReflection->getWritableType();
        if ($propertyReflection->getNativeType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            if ($default instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch && (string) $default->name === 'null') {
                return [];
            }
        }
        $defaultValueType = $scope->getType($default);
        if ($this->ruleLevelHelper->accepts($propertyType, $defaultValueType, \true)) {
            return [];
        }
        $verbosityLevel = \_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($propertyType);
        return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s::$%s (%s) does not accept default value of type %s.', $node->isStatic() ? 'Static property' : 'Property', $classReflection->getDisplayName(), $node->getName(), $propertyType->describe($verbosityLevel), $defaultValueType->describe($verbosityLevel)))->build()];
    }
}
