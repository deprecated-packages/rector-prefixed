<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Exceptions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\Throw_>
 */
class ThrowExpressionRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\RectorPrefix20201227\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Throw_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->phpVersion->supportsThrowExpression()) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Throw expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
    }
}
