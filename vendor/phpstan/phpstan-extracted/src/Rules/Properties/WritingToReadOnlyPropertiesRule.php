<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class WritingToReadOnlyPropertiesRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, bool $checkThisOnly)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->checkThisOnly = $checkThisOnly;
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
        if ($node->var instanceof \PhpParser\Node\Expr\PropertyFetch && $this->checkThisOnly && !$this->ruleLevelHelper->isThis($node->var->var)) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch */
        $propertyFetch = $node->var;
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyFetch, $scope);
        if ($propertyReflection === null) {
            return [];
        }
        if (!$scope->canAccessProperty($propertyReflection)) {
            return [];
        }
        if (!$propertyReflection->isWritable()) {
            $propertyDescription = $this->propertyDescriptor->describeProperty($propertyReflection, $propertyFetch);
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not writable.', $propertyDescription))->build()];
        }
        return [];
    }
}
