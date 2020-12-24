<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\AssignOp>
 */
class OffsetAccessAssignOpRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        $potentialDimType = null;
        if ($arrayDimFetch->dim !== null) {
            $potentialDimType = $scope->getType($arrayDimFetch->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($arrayDimFetch->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->dim, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
            if ($varType->hasOffsetValueType($dimType)->no()) {
                return [];
            }
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        if (!$resultType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
