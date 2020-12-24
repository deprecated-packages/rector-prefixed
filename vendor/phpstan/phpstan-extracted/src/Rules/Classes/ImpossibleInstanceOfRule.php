<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Classes;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Instanceof_>
 */
class ImpossibleInstanceOfRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
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
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $instanceofType = $scope->getType($node);
        $expressionType = $scope->getType($node->expr);
        if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $className = $scope->resolveName($node->class);
            $classType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
        } else {
            $classType = $scope->getType($node->class);
            $allowed = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType());
            if (!$allowed->accepts($classType, \true)->yes()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s results in an error.', $expressionType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
            }
        }
        if (!$instanceofType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $addTip = function (\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $instanceofTypeWithoutPhpDocs = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node);
            if ($instanceofTypeWithoutPhpDocs instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        if (!$instanceofType->getValue()) {
            return [$addTip(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to false.', $expressionType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        } elseif ($this->checkAlwaysTrueInstanceof) {
            return [$addTip(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to true.', $expressionType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        }
        return [];
    }
}
