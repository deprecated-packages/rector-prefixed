<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\MatchExpressionNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<MatchExpressionNode>
 */
class MatchExpressionRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\MatchExpressionNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $matchCondition = $node->getCondition();
        $nextArmIsDead = \false;
        $errors = [];
        $armsCount = \count($node->getArms());
        $hasDefault = \false;
        foreach ($node->getArms() as $i => $arm) {
            if ($nextArmIsDead) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Match arm is unreachable because previous comparison is always true.')->line($arm->getLine())->build();
                continue;
            }
            $armConditions = $arm->getConditions();
            if (\count($armConditions) === 0) {
                $hasDefault = \true;
            }
            foreach ($armConditions as $armCondition) {
                $armConditionScope = $armCondition->getScope();
                $armConditionExpr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($matchCondition, $armCondition->getCondition());
                $armConditionResult = $armConditionScope->getType($armConditionExpr);
                if (!$armConditionResult instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                    continue;
                }
                $armLine = $armCondition->getLine();
                if (!$armConditionResult->getValue()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always false.', $armConditionScope->getType($matchCondition)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                } else {
                    $nextArmIsDead = \true;
                    if ($this->checkAlwaysTrueStrictComparison && ($i !== $armsCount - 1 || $i === 0)) {
                        $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always true.', $armConditionScope->getType($matchCondition)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                    }
                }
            }
        }
        if (!$hasDefault && !$nextArmIsDead) {
            $remainingType = $node->getEndScope()->getType($matchCondition);
            if (!$remainingType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match expression does not handle remaining %s: %s', $remainingType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType ? 'values' : 'value', $remainingType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->build();
            }
        }
        return $errors;
    }
}
