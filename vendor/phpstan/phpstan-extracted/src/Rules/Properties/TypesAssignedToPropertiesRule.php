<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleError;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class TypesAssignedToPropertiesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \RectorPrefix20201227\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
    private function processSingleProperty(\RectorPrefix20201227\PHPStan\Rules\Properties\FoundPropertyReflection $propertyReflection, \PhpParser\Node\Expr $node) : array
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
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s (%s) does not accept %s.', $propertyDescription, $propertyType->describe($verbosityLevel), $assignedValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
