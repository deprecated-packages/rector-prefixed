<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Comparison;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\MatchExpressionNode;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<MatchExpressionNode>
 */
class MatchExpressionRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\MatchExpressionNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $matchCondition = $node->getCondition();
        $nextArmIsDead = \false;
        $errors = [];
        $armsCount = \count($node->getArms());
        $hasDefault = \false;
        foreach ($node->getArms() as $i => $arm) {
            if ($nextArmIsDead) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Match arm is unreachable because previous comparison is always true.')->line($arm->getLine())->build();
                continue;
            }
            $armConditions = $arm->getConditions();
            if (\count($armConditions) === 0) {
                $hasDefault = \true;
            }
            foreach ($armConditions as $armCondition) {
                $armConditionScope = $armCondition->getScope();
                $armConditionExpr = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($matchCondition, $armCondition->getCondition());
                $armConditionResult = $armConditionScope->getType($armConditionExpr);
                if (!$armConditionResult instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType) {
                    continue;
                }
                $armLine = $armCondition->getLine();
                if (!$armConditionResult->getValue()) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always false.', $armConditionScope->getType($matchCondition)->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                } else {
                    $nextArmIsDead = \true;
                    if ($this->checkAlwaysTrueStrictComparison && ($i !== $armsCount - 1 || $i === 0)) {
                        $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always true.', $armConditionScope->getType($matchCondition)->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                    }
                }
            }
        }
        if (!$hasDefault && !$nextArmIsDead) {
            $remainingType = $node->getEndScope()->getType($matchCondition);
            if (!$remainingType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match expression does not handle remaining %s: %s', $remainingType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType ? 'values' : 'value', $remainingType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->build();
            }
        }
        return $errors;
    }
}
