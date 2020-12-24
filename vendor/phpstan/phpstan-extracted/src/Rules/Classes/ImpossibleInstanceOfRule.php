<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Classes;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Instanceof_>
 */
class ImpossibleInstanceOfRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueInstanceof;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(bool $checkAlwaysTrueInstanceof, bool $treatPhpDocTypesAsCertain)
    {
        $this->checkAlwaysTrueInstanceof = $checkAlwaysTrueInstanceof;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $instanceofType = $scope->getType($node);
        $expressionType = $scope->getType($node->expr);
        if ($node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $className = $scope->resolveName($node->class);
            $classType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className);
        } else {
            $classType = $scope->getType($node->class);
            $allowed = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType());
            if (!$allowed->accepts($classType, \true)->yes()) {
                return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s results in an error.', $expressionType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
            }
        }
        if (!$instanceofType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $addTip = function (\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $instanceofTypeWithoutPhpDocs = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node);
            if ($instanceofTypeWithoutPhpDocs instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        if (!$instanceofType->getValue()) {
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to false.', $expressionType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        } elseif ($this->checkAlwaysTrueInstanceof) {
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to true.', $expressionType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        }
        return [];
    }
}
