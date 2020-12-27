<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\NullsafeCheck;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\ArrowFunction>
 */
class ArrowFunctionReturnNullsafeByRefRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->byRef) {
            return [];
        }
        if (!$this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [];
        }
        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->nonIgnorable()->build()];
    }
}
