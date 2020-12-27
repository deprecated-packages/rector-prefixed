<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Properties;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessPropertiesInAssignRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessPropertiesRule */
    private $accessPropertiesRule;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Properties\AccessPropertiesRule $accessPropertiesRule)
    {
        $this->accessPropertiesRule = $accessPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return [];
        }
        return $this->accessPropertiesRule->processNode($node->var, $scope);
    }
}
