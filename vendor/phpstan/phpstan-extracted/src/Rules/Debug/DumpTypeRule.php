<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Debug;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\FuncCall>
 */
class DumpTypeRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing argument for %s() function call.', $functionName))->nonIgnorable()->build()];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dumped type: %s', $scope->getType($node->args[0]->value)->describe(\PHPStan\Type\VerbosityLevel::precise())))->nonIgnorable()->build()];
    }
}
