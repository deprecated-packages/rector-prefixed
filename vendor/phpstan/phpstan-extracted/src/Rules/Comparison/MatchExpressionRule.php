<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\MatchExpressionNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<MatchExpressionNode>
 */
class MatchExpressionRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\MatchExpressionNode::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $matchCondition = $node->getCondition();
        $nextArmIsDead = \false;
        $errors = [];
        $armsCount = \count($node->getArms());
        $hasDefault = \false;
        foreach ($node->getArms() as $i => $arm) {
            if ($nextArmIsDead) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message('Match arm is unreachable because previous comparison is always true.')->line($arm->getLine())->build();
                continue;
            }
            $armConditions = $arm->getConditions();
            if (\count($armConditions) === 0) {
                $hasDefault = \true;
            }
            foreach ($armConditions as $armCondition) {
                $armConditionScope = $armCondition->getScope();
                $armConditionExpr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical($matchCondition, $armCondition->getCondition());
                $armConditionResult = $armConditionScope->getType($armConditionExpr);
                if (!$armConditionResult instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
                    continue;
                }
                $armLine = $armCondition->getLine();
                if (!$armConditionResult->getValue()) {
                    $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always false.', $armConditionScope->getType($matchCondition)->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                } else {
                    $nextArmIsDead = \true;
                    if ($this->checkAlwaysTrueStrictComparison && ($i !== $armsCount - 1 || $i === 0)) {
                        $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always true.', $armConditionScope->getType($matchCondition)->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                    }
                }
            }
        }
        if (!$hasDefault && !$nextArmIsDead) {
            $remainingType = $node->getEndScope()->getType($matchCondition);
            if (!$remainingType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match expression does not handle remaining %s: %s', $remainingType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType ? 'values' : 'value', $remainingType->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::value())))->build();
            }
        }
        return $errors;
    }
}
