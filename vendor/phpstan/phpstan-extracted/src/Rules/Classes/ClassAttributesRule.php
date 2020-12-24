<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Classes;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\AttributesCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
/**
 * @implements Rule<Node\Stmt\ClassLike>
 */
class ClassAttributesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var AttributesCheck */
    private $attributesCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\AttributesCheck $attributesCheck)
    {
        $this->attributesCheck = $attributesCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        return $this->attributesCheck->check($scope, $node->attrGroups, \Attribute::TARGET_CLASS, 'class');
    }
}
