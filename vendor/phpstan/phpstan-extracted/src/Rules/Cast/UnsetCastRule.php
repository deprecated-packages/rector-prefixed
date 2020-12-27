<?php

declare (strict_types=1);
namespace PHPStan\Rules\Cast;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Php\PhpVersion;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\Cast\Unset_>
 */
class UnsetCastRule implements \PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Cast\Unset_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->phpVersion->supportsUnsetCast()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('The (unset) cast is no longer supported in PHP 8.0 and later.')->nonIgnorable()->build()];
    }
}
