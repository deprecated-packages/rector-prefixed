<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Properties;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Assign>
 */
class AccessStaticPropertiesInAssignRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Properties\AccessStaticPropertiesRule */
    private $accessStaticPropertiesRule;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\AccessStaticPropertiesRule $accessStaticPropertiesRule)
    {
        $this->accessStaticPropertiesRule = $accessStaticPropertiesRule;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [];
        }
        return $this->accessStaticPropertiesRule->processNode($node->var, $scope);
    }
}
