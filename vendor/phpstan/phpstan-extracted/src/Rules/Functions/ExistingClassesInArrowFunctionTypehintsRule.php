<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrowFunction>
 */
class ExistingClassesInArrowFunctionTypehintsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionDefinitionCheck */
    private $check;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        return $this->check->checkAnonymousFunction($scope, $node->getParams(), $node->getReturnType(), 'Parameter $%s of anonymous function has invalid typehint type %s.', 'Return typehint of anonymous function has invalid type %s.', 'Anonymous function uses native union types but they\'re supported only on PHP 8.0 and later.');
    }
}
