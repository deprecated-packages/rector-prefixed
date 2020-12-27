<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Arrays;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class OffsetAccessAssignmentRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInExpressionAssign($node)) {
            return [];
        }
        $potentialDimType = null;
        if ($node->dim !== null) {
            $potentialDimType = $scope->getType($node->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, '', static function (\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($varType instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$varType->isOffsetAccessible()->yes()) {
            return [];
        }
        if ($node->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->dim, '', static function (\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \PHPStan\Type\MixedType());
        if (!$resultType instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
