<?php

declare (strict_types=1);
namespace PHPStan\Rules\Debug;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\FuncCall>
 */
class DumpTypeRule implements \PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Name) {
            return [];
        }
        $functionName = $this->reflectionProvider->resolveFunctionName($node->name, $scope);
        if ($functionName === null) {
            return [];
        }
        if (\strtolower($functionName) !== 'phpstan\\dumptype') {
            return [];
        }
        if (\count($node->args) === 0) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing argument for %s() function call.', $functionName))->nonIgnorable()->build()];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dumped type: %s', $scope->getType($node->args[0]->value)->describe(\PHPStan\Type\VerbosityLevel::precise())))->nonIgnorable()->build()];
    }
}
