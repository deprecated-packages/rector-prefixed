<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessPropertiesInAssignRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessPropertiesRule */
    private $accessPropertiesRule;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\AccessPropertiesRule $accessPropertiesRule)
    {
        $this->accessPropertiesRule = $accessPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return [];
        }
        return $this->accessPropertiesRule->processNode($node->var, $scope);
    }
}
