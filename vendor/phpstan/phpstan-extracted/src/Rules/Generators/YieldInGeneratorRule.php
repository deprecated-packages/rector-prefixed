<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Generators;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class YieldInGeneratorRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Yield_ && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\YieldFrom) {
            return [];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
        } elseif ($scopeFunction !== null) {
            $returnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
        } else {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Yield can be used only inside a function.')->build()];
        }
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return [];
        }
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            $isSuperType = \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
        } else {
            $isSuperType = $returnType->isIterable()->and(\_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean(!$returnType->isArray()->yes()));
        }
        if ($isSuperType->yes()) {
            return [];
        }
        if ($isSuperType->maybe() && !$this->reportMaybes) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Yield can be used only with these return types: %s.', 'Generator, Iterator, Traversable, iterable'))->build()];
    }
}
