<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Generators;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class YieldInGeneratorRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Yield_ && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\YieldFrom) {
            return [];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Yield can be used only inside a function.')->build()];
        }
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return [];
        }
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            $isSuperType = \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        } else {
            $isSuperType = $returnType->isIterable()->and(\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean(!$returnType->isArray()->yes()));
        }
        if ($isSuperType->yes()) {
            return [];
        }
        if ($isSuperType->maybe() && !$this->reportMaybes) {
            return [];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Yield can be used only with these return types: %s.', 'Generator, Iterator, Traversable, iterable'))->build()];
    }
}
