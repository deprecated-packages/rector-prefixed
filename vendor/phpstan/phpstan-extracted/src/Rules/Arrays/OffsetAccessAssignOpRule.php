<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Arrays;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\AssignOp>
 */
class OffsetAccessAssignOpRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        $potentialDimType = null;
        if ($arrayDimFetch->dim !== null) {
            $potentialDimType = $scope->getType($arrayDimFetch->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($arrayDimFetch->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->dim, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
            if ($varType->hasOffsetValueType($dimType)->no()) {
                return [];
            }
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        if (!$resultType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
