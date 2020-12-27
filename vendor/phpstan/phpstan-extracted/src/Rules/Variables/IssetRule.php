<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Variables;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr\Isset_>
 */
class IssetRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var IssetCheck */
    private $issetCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Isset_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
