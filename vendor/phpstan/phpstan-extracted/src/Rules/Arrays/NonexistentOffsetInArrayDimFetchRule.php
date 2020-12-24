<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Arrays;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class NonexistentOffsetInArrayDimFetchRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->dim !== null) {
            $dimType = $scope->getType($node->dim);
            $unknownClassPattern = \sprintf('Access to offset %s on an unknown class %%s.', $dimType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()));
        } else {
            $dimType = null;
            $unknownClassPattern = 'Access to an offset on an unknown class %s.';
        }
        $isOffsetAccessibleTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, $unknownClassPattern, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
            return $type->isOffsetAccessible()->yes();
        });
        $isOffsetAccessibleType = $isOffsetAccessibleTypeResult->getType();
        if ($isOffsetAccessibleType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return $isOffsetAccessibleTypeResult->getUnknownClassErrors();
        }
        $isOffsetAccessible = $isOffsetAccessibleType->isOffsetAccessible();
        if ($scope->isInExpressionAssign($node) && $isOffsetAccessible->yes()) {
            return [];
        }
        if (!$isOffsetAccessible->yes()) {
            if ($isOffsetAccessible->no() || $this->reportMaybes) {
                if ($dimType !== null) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access offset %s on %s.', $dimType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $isOffsetAccessibleType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->build()];
                }
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access an offset on %s.', $isOffsetAccessibleType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
            }
            return [];
        }
        if ($dimType === null) {
            return [];
        }
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, $unknownClassPattern, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($dimType) : bool {
            return $type->hasOffsetValueType($dimType)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $hasOffsetValueType = $type->hasOffsetValueType($dimType);
        $report = $hasOffsetValueType->no();
        if ($hasOffsetValueType->maybe()) {
            $constantArrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getOldConstantArrays($type);
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
            foreach (\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::flattenTypes($type) as $innerType) {
                if ($dimType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
                    if ($innerType->hasOffsetValueType($dimType)->no()) {
                        $report = \true;
                        break;
                    }
                    continue;
                }
                foreach (\_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::flattenTypes($dimType) as $innerDimType) {
                    if ($innerType->hasOffsetValueType($innerDimType)->no()) {
                        $report = \true;
                        break;
                    }
                }
            }
        }
        if ($report) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Offset %s does not exist on %s.', $dimType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
