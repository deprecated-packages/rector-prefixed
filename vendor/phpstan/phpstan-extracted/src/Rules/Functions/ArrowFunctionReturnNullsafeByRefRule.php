<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\NullsafeCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\ArrowFunction>
 */
class ArrowFunctionReturnNullsafeByRefRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->byRef) {
            return [];
        }
        if (!$this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->nonIgnorable()->build()];
    }
}
