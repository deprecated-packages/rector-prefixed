<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class TypesAssignedToPropertiesRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign && !$node instanceof \PhpParser\Node\Expr\AssignOp && !$node instanceof \PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
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
    private function processSingleProperty(\PHPStan\Rules\Properties\FoundPropertyReflection $propertyReflection, \PhpParser\Node\Expr $node) : array
    {
        $propertyType = $propertyReflection->getWritableType();
        $scope = $propertyReflection->getScope();
        if ($node instanceof \PhpParser\Node\Expr\Assign || $node instanceof \PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        if (!$this->ruleLevelHelper->accepts($propertyType, $assignedValueType, $scope->isDeclareStrictTypes())) {
            $propertyDescription = $this->propertyDescriptor->describePropertyByName($propertyReflection, $propertyReflection->getName());
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($propertyType);
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s (%s) does not accept %s.', $propertyDescription, $propertyType->describe($verbosityLevel), $assignedValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
