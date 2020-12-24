<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ElseIf_>
 */
class ElseIfConstantConditionRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ElseIf_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $exprType = $this->helper->getBooleanType($scope, $node->cond);
        if ($exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
            $addTip = function (\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope, $node->cond);
                if ($booleanNativeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
            };
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Elseif condition is always %s.', $exprType->getValue() ? 'true' : 'false')))->line($node->cond->getLine())->identifier('deadCode.elseifConstantCondition')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder'), 'value' => $exprType->getValue()])->build()];
        }
        return [];
    }
}
