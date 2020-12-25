<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PhpParser\Node\Expr\ArrayDimFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\AssignOp>
 */
class OffsetAccessAssignOpRule implements \PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\AssignOp::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        $potentialDimType = null;
        if ($arrayDimFetch->dim !== null) {
            $potentialDimType = $scope->getType($arrayDimFetch->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($arrayDimFetch->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->dim, '', static function (\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
            if ($varType->hasOffsetValueType($dimType)->no()) {
                return [];
            }
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \PHPStan\Type\MixedType());
        if (!$resultType instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
