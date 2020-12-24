<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Debug;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Expr\FuncCall>
 */
class DumpTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
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
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing argument for %s() function call.', $functionName))->nonIgnorable()->build()];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dumped type: %s', $scope->getType($node->args[0]->value)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::precise())))->nonIgnorable()->build()];
    }
}
