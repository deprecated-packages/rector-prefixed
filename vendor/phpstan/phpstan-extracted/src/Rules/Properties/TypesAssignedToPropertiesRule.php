<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleError;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class TypesAssignedToPropertiesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch */
        $propertyFetch = $node->var;
        $propertyReflections = $this->propertyReflectionFinder->findPropertyReflectionsFromNode($propertyFetch, $scope);
        $errors = [];
        foreach ($propertyReflections as $propertyReflection) {
            $errors = \array_merge($errors, $this->processSingleProperty($propertyReflection, $node));
        }
        return $errors;
    }
    /**
     * @param FoundPropertyReflection $propertyReflection
     * @param Node\Expr $node
     * @return RuleError[]
     */
    private function processSingleProperty(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\FoundPropertyReflection $propertyReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr $node) : array
    {
        $propertyType = $propertyReflection->getWritableType();
        $scope = $propertyReflection->getScope();
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        if (!$this->ruleLevelHelper->accepts($propertyType, $assignedValueType, $scope->isDeclareStrictTypes())) {
            $propertyDescription = $this->propertyDescriptor->describePropertyByName($propertyReflection, $propertyReflection->getName());
            $verbosityLevel = \_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($propertyType);
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s (%s) does not accept %s.', $propertyDescription, $propertyType->describe($verbosityLevel), $assignedValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
