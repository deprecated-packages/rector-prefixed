<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class NonexistentOffsetInArrayDimFetchRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->dim !== null) {
            $dimType = $scope->getType($node->dim);
            $unknownClassPattern = \sprintf('Access to offset %s on an unknown class %%s.', $dimType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()));
        } else {
            $dimType = null;
            $unknownClassPattern = 'Access to an offset on an unknown class %s.';
        }
        $isOffsetAccessibleTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, $unknownClassPattern, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
            return $type->isOffsetAccessible()->yes();
        });
        $isOffsetAccessibleType = $isOffsetAccessibleTypeResult->getType();
        if ($isOffsetAccessibleType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return $isOffsetAccessibleTypeResult->getUnknownClassErrors();
        }
        $isOffsetAccessible = $isOffsetAccessibleType->isOffsetAccessible();
        if ($scope->isInExpressionAssign($node) && $isOffsetAccessible->yes()) {
            return [];
        }
        if (!$isOffsetAccessible->yes()) {
            if ($isOffsetAccessible->no() || $this->reportMaybes) {
                if ($dimType !== null) {
                    return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access offset %s on %s.', $dimType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $isOffsetAccessibleType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
                }
                return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access an offset on %s.', $isOffsetAccessibleType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
            }
            return [];
        }
        if ($dimType === null) {
            return [];
        }
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, $unknownClassPattern, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($dimType) : bool {
            return $type->hasOffsetValueType($dimType)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $hasOffsetValueType = $type->hasOffsetValueType($dimType);
        $report = $hasOffsetValueType->no();
        if ($hasOffsetValueType->maybe()) {
            $constantArrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getOldConstantArrays($type);
            if (\count($constantArrays) > 0) {
                foreach ($constantArrays as $constantArray) {
                    if ($constantArray->hasOffsetValueType($dimType)->no()) {
                        $report = \true;
                        break;
                    }
                }
            }
        }
        if (!$report && $this->reportMaybes) {
            foreach (\_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::flattenTypes($type) as $innerType) {
                if ($dimType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                    if ($innerType->hasOffsetValueType($dimType)->no()) {
                        $report = \true;
                        break;
                    }
                    continue;
                }
                foreach (\_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::flattenTypes($dimType) as $innerDimType) {
                    if ($innerType->hasOffsetValueType($innerDimType)->no()) {
                        $report = \true;
                        break;
                    }
                }
            }
        }
        if ($report) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Offset %s does not exist on %s.', $dimType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
