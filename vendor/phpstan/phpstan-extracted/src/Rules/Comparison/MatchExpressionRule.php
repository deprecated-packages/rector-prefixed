<?php

declare (strict_types=1);
namespace PHPStan\Rules\Comparison;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\MatchExpressionNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\NeverType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<MatchExpressionNode>
 */
class MatchExpressionRule implements \PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\MatchExpressionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $matchCondition = $node->getCondition();
        $nextArmIsDead = \false;
        $errors = [];
        $armsCount = \count($node->getArms());
        $hasDefault = \false;
        foreach ($node->getArms() as $i => $arm) {
            if ($nextArmIsDead) {
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message('Match arm is unreachable because previous comparison is always true.')->line($arm->getLine())->build();
                continue;
            }
            $armConditions = $arm->getConditions();
            if (\count($armConditions) === 0) {
                $hasDefault = \true;
            }
            foreach ($armConditions as $armCondition) {
                $armConditionScope = $armCondition->getScope();
                $armConditionExpr = new \PhpParser\Node\Expr\BinaryOp\Identical($matchCondition, $armCondition->getCondition());
                $armConditionResult = $armConditionScope->getType($armConditionExpr);
                if (!$armConditionResult instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    continue;
                }
                $armLine = $armCondition->getLine();
                if (!$armConditionResult->getValue()) {
                    $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always false.', $armConditionScope->getType($matchCondition)->describe(\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                } else {
                    $nextArmIsDead = \true;
                    if ($this->checkAlwaysTrueStrictComparison && ($i !== $armsCount - 1 || $i === 0)) {
                        $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always true.', $armConditionScope->getType($matchCondition)->describe(\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                    }
                }
            }
        }
        if (!$hasDefault && !$nextArmIsDead) {
            $remainingType = $node->getEndScope()->getType($matchCondition);
            if (!$remainingType instanceof \PHPStan\Type\NeverType) {
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match expression does not handle remaining %s: %s', $remainingType instanceof \PHPStan\Type\UnionType ? 'values' : 'value', $remainingType->describe(\PHPStan\Type\VerbosityLevel::value())))->build();
            }
        }
        return $errors;
    }
}
