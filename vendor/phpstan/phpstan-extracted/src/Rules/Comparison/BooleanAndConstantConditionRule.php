<?php

declare (strict_types=1);
namespace PHPStan\Rules\Comparison;

use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp\BooleanAnd>
 */
class BooleanAndConstantConditionRule implements \PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\BinaryOp\BooleanAnd::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        $leftType = $this->helper->getBooleanType($scope, $node->left);
        $tipText = 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';
        if ($leftType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            $addTipLeft = function (\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope, $node->left);
                if ($booleanNativeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip($tipText);
            };
            $errors[] = $addTipLeft(\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Left side of && is always %s.', $leftType->getValue() ? 'true' : 'false')))->line($node->left->getLine())->build();
        }
        $rightType = $this->helper->getBooleanType($scope->filterByTruthyValue($node->left), $node->right);
        if ($rightType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            $addTipRight = function (\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope->doNotTreatPhpDocTypesAsCertain()->filterByTruthyValue($node->left), $node->right);
                if ($booleanNativeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip($tipText);
            };
            $errors[] = $addTipRight(\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Right side of && is always %s.', $rightType->getValue() ? 'true' : 'false')))->line($node->right->getLine())->build();
        }
        if (\count($errors) === 0) {
            $nodeType = $scope->getType($node);
            if ($nodeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                $addTip = function (\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                    if (!$this->treatPhpDocTypesAsCertain) {
                        return $ruleErrorBuilder;
                    }
                    $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node);
                    if ($booleanNativeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                        return $ruleErrorBuilder;
                    }
                    return $ruleErrorBuilder->tip($tipText);
                };
                $errors[] = $addTip(\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Result of && is always %s.', $nodeType->getValue() ? 'true' : 'false')))->build();
            }
        }
        return $errors;
    }
}
