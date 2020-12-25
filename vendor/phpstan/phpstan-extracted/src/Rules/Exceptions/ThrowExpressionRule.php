<?php

declare (strict_types=1);
namespace PHPStan\Rules\Exceptions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Php\PhpVersion;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\Throw_>
 */
class ThrowExpressionRule implements \PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Throw_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->phpVersion->supportsThrowExpression()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('Throw expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
    }
}
