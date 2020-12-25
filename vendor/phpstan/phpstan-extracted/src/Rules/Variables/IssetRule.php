<?php

declare (strict_types=1);
namespace PHPStan\Rules\Variables;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr\Isset_>
 */
class IssetRule implements \PHPStan\Rules\Rule
{
    /** @var IssetCheck */
    private $issetCheck;
    public function __construct(\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Isset_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->vars as $var) {
            $error = $this->issetCheck->check($var, $scope, 'in isset()');
            if ($error === null) {
                continue;
            }
            $messages[] = $error;
        }
        return $messages;
    }
}
