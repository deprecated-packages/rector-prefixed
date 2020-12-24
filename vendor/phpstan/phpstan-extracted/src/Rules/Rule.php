<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
/**
 * @phpstan-template TNodeType of \PhpParser\Node
 */
interface Rule
{
    /**
     * @phpstan-return class-string<TNodeType>
     * @return string
     */
    public function getNodeType() : string;
    /**
     * @phpstan-param TNodeType $node
     * @param \PhpParser\Node $node
     * @param \PHPStan\Analyser\Scope $scope
     * @return (string|RuleError)[] errors
     */
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array;
}
