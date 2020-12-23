<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Arrays;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class OffsetAccessAssignmentRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInExpressionAssign($node)) {
            return [];
        }
        $potentialDimType = null;
        if ($node->dim !== null) {
            $potentialDimType = $scope->getType($node->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, '', static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($varType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$varType->isOffsetAccessible()->yes()) {
            return [];
        }
        if ($node->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->dim, '', static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
        if (!$resultType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
