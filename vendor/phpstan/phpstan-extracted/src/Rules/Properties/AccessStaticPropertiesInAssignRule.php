<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Properties;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessStaticPropertiesInAssignRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessStaticPropertiesRule */
    private $accessStaticPropertiesRule;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\Properties\AccessStaticPropertiesRule $accessStaticPropertiesRule)
    {
        $this->accessStaticPropertiesRule = $accessStaticPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        return $this->accessStaticPropertiesRule->processNode($node->var, $scope);
    }
}
