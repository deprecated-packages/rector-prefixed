<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\If_>
 */
class UnreachableIfBranchesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        $condition = $node->cond;
        $conditionType = $scope->getType($condition)->toBoolean();
        $nextBranchIsDead = $conditionType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $node->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($node->cond);
        $addTip = function (\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, &$condition) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($condition)->toBoolean();
            if ($booleanNativeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        foreach ($node->elseifs as $elseif) {
            if ($nextBranchIsDead) {
                $errors[] = $addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Elseif branch is unreachable because previous condition is always true.')->line($elseif->getLine()))->identifier('deadCode.unreachableElseif')->metadata(['ifDepth' => $node->getAttribute('statementDepth'), 'ifOrder' => $node->getAttribute('statementOrder'), 'depth' => $elseif->getAttribute('statementDepth'), 'order' => $elseif->getAttribute('statementOrder')])->build();
                continue;
            }
            $condition = $elseif->cond;
            $conditionType = $scope->getType($condition)->toBoolean();
            $nextBranchIsDead = $conditionType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $elseif->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($elseif->cond);
        }
        if ($node->else !== null && $nextBranchIsDead) {
            $errors[] = $addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Else branch is unreachable because previous condition is always true.'))->line($node->else->getLine())->identifier('deadCode.unreachableElse')->metadata(['ifDepth' => $node->getAttribute('statementDepth'), 'ifOrder' => $node->getAttribute('statementOrder')])->build();
        }
        return $errors;
    }
}
