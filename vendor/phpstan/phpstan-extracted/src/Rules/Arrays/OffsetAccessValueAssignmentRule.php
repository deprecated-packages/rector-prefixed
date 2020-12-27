<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Arrays;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignOp;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<Expr>
 */
class OffsetAccessValueAssignmentRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
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
        if (!$node->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        if ($node instanceof \PhpParser\Node\Expr\Assign || $node instanceof \PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        $originalArrayType = $scope->getType($arrayDimFetch->var);
        $arrayTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\PHPStan\Type\Type $varType) use($assignedValueType) : bool {
            $result = $varType->setOffsetValueType(new \PHPStan\Type\MixedType(), $assignedValueType);
            return !$result instanceof \PHPStan\Type\ErrorType;
        });
        $arrayType = $arrayTypeResult->getType();
        if ($arrayType instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        $isOffsetAccessible = $arrayType->isOffsetAccessible();
        if (!$isOffsetAccessible->yes()) {
            return [];
        }
        $resultType = $arrayType->setOffsetValueType(new \PHPStan\Type\MixedType(), $assignedValueType);
        if (!$resultType instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s does not accept %s.', $originalArrayType->describe(\PHPStan\Type\VerbosityLevel::value()), $assignedValueType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
