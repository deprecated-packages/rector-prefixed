<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Generators;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class YieldInGeneratorRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_ && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom) {
            return [];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Yield can be used only inside a function.')->build()];
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return [];
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            $isSuperType = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        } else {
            $isSuperType = $returnType->isIterable()->and(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean(!$returnType->isArray()->yes()));
        }
        if ($isSuperType->yes()) {
            return [];
        }
        if ($isSuperType->maybe() && !$this->reportMaybes) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Yield can be used only with these return types: %s.', 'Generator, Iterator, Traversable, iterable'))->build()];
    }
}
