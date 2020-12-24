<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Arrays;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class OffsetAccessAssignmentRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInExpressionAssign($node)) {
            return [];
        }
        $potentialDimType = null;
        if ($node->dim !== null) {
            $potentialDimType = $scope->getType($node->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$varType->isOffsetAccessible()->yes()) {
            return [];
        }
        if ($node->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->dim, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
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
