<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Generators;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class YieldInGeneratorRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\Yield_ && !$node instanceof \PhpParser\Node\Expr\YieldFrom) {
            return [];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Yield can be used only inside a function.')->build()];
        }
        if ($returnType instanceof \PHPStan\Type\MixedType) {
            return [];
        }
        if ($returnType instanceof \PHPStan\Type\NeverType && $returnType->isExplicit()) {
            $isSuperType = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        } else {
            $isSuperType = $returnType->isIterable()->and(\RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean(!$returnType->isArray()->yes()));
        }
        if ($isSuperType->yes()) {
            return [];
        }
        if ($isSuperType->maybe() && !$this->reportMaybes) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Yield can be used only with these return types: %s.', 'Generator, Iterator, Traversable, iterable'))->build()];
    }
}
