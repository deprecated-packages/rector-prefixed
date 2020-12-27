<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\AttributesCheck;
use RectorPrefix20201227\PHPStan\Rules\Rule;
/**
 * @implements Rule<Node\Stmt\Function_>
 */
class FunctionAttributesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var AttributesCheck */
    private $attributesCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\AttributesCheck $attributesCheck)
    {
        $this->attributesCheck = $attributesCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Function_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        return $this->attributesCheck->check($scope, $node->attrGroups, \Attribute::TARGET_FUNCTION, 'function');
    }
}
