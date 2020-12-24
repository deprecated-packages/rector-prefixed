<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Arrays;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class AppendedArrayItemTypeRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        if (!$node->var->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch && !$node->var->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($node->var->var, $scope);
        if ($propertyReflection === null) {
            return [];
        }
        $assignedToType = $propertyReflection->getWritableType();
        if (!$assignedToType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return [];
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        $itemType = $assignedToType->getItemType();
        if (!$this->ruleLevelHelper->accepts($itemType, $assignedValueType, $scope->isDeclareStrictTypes())) {
            $verbosityLevel = \_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($itemType);
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Array (%s) does not accept %s.', $assignedToType->describe($verbosityLevel), $assignedValueType->describe($verbosityLevel)))->build()];
        }
        return [];
    }
}
