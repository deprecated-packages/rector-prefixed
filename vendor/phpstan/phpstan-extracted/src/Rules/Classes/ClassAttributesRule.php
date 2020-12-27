<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\AttributesCheck;
use PHPStan\Rules\Rule;
/**
 * @implements Rule<Node\Stmt\ClassLike>
 */
class ClassAttributesRule implements \PHPStan\Rules\Rule
{
    /** @var AttributesCheck */
    private $attributesCheck;
    public function __construct(\PHPStan\Rules\AttributesCheck $attributesCheck)
    {
        $this->attributesCheck = $attributesCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\ClassLike::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        return $this->attributesCheck->check($scope, $node->attrGroups, \Attribute::TARGET_CLASS, 'class');
    }
}
