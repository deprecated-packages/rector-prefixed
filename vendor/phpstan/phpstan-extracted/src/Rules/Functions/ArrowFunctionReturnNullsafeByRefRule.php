<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\ArrowFunction>
 */
class ArrowFunctionReturnNullsafeByRefRule implements \PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->byRef) {
            return [];
        }
        if (!$this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->nonIgnorable()->build()];
    }
}
