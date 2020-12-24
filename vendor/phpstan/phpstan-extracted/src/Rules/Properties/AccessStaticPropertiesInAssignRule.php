<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessStaticPropertiesInAssignRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessStaticPropertiesRule */
    private $accessStaticPropertiesRule;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\AccessStaticPropertiesRule $accessStaticPropertiesRule)
    {
        $this->accessStaticPropertiesRule = $accessStaticPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        return $this->accessStaticPropertiesRule->processNode($node->var, $scope);
    }
}
