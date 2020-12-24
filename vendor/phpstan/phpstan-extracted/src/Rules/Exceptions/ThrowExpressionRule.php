<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Exceptions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\Throw_>
 */
class ThrowExpressionRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Throw_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->phpVersion->supportsThrowExpression()) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('Throw expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
    }
}
