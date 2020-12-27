<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToFunctionStamentWithoutSideEffectsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\FuncCall) {
            return [];
        }
        $funcCall = $node->expr;
        if (!$funcCall->name instanceof \PhpParser\Node\Name) {
            return [];
        }
        if (!$this->reflectionProvider->hasFunction($funcCall->name, $scope)) {
            return [];
        }
        $function = $this->reflectionProvider->getFunction($funcCall->name, $scope);
        if ($function->hasSideEffects()->no()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function %s() on a separate line has no effect.', $function->getName()))->build()];
        }
        return [];
    }
}
