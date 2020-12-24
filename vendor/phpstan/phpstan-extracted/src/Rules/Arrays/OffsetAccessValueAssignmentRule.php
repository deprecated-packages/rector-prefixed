<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Arrays;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<Expr>
 */
class OffsetAccessValueAssignmentRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        $originalArrayType = $scope->getType($arrayDimFetch->var);
        $arrayTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $varType) use($assignedValueType) : bool {
            $result = $varType->setOffsetValueType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $assignedValueType);
            return !$result instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
        });
        $arrayType = $arrayTypeResult->getType();
        if ($arrayType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [];
        }
        $isOffsetAccessible = $arrayType->isOffsetAccessible();
        if (!$isOffsetAccessible->yes()) {
            return [];
        }
        $resultType = $arrayType->setOffsetValueType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), $assignedValueType);
        if (!$resultType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s does not accept %s.', $originalArrayType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $assignedValueType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
