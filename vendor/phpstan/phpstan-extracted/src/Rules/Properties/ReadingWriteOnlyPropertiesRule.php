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
class ReadingWriteOnlyPropertiesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $checkThisOnly)
    {
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && $this->checkThisOnly && !$this->ruleLevelHelper->isThis($node->var)) {
            return [];
        }
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($node, $scope);
        if ($propertyReflection === null) {
            return [];
        }
        if (!$scope->canAccessProperty($propertyReflection)) {
            return [];
        }
        if (!$propertyReflection->isReadable()) {
            $propertyDescription = $this->propertyDescriptor->describeProperty($propertyReflection, $node);
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not readable.', $propertyDescription))->build()];
        }
        return [];
    }
}
