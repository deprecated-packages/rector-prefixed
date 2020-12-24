<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class WritingToReadOnlyPropertiesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, bool $checkThisOnly)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->checkThisOnly = $checkThisOnly;
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
        if ($node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && $this->checkThisOnly && !$this->ruleLevelHelper->isThis($node->var->var)) {
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
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not writable.', $propertyDescription))->build()];
        }
        return [];
    }
}
