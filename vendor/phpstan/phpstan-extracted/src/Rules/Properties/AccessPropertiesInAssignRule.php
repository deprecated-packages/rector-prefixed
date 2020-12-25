<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessPropertiesInAssignRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessPropertiesRule */
    private $accessPropertiesRule;
    public function __construct(\PHPStan\Rules\Properties\AccessPropertiesRule $accessPropertiesRule)
    {
        $this->accessPropertiesRule = $accessPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return [];
        }
        return $this->accessPropertiesRule->processNode($node->var, $scope);
    }
}
