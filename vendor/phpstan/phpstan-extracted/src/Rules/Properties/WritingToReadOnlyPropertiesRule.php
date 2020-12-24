<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleLevelHelper;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class WritingToReadOnlyPropertiesRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\Properties\PropertyDescriptor */
    private $propertyDescriptor;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, bool $checkThisOnly)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        if ($node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch && $this->checkThisOnly && !$this->ruleLevelHelper->isThis($node->var->var)) {
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
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not writable.', $propertyDescription))->build()];
        }
        return [];
    }
}
