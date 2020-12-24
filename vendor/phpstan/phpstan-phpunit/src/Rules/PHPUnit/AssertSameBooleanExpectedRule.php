<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\NodeAbstract>
 */
class AssertSameBooleanExpectedRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!\_PhpScoperb75b35f52b74\PHPStan\Rules\PHPUnit\AssertRuleHelper::isMethodOrStaticCallOnAssert($node, $scope)) {
            return [];
        }
        /** @var \PhpParser\Node\Expr\MethodCall|\PhpParser\Node\Expr\StaticCall $node */
        $node = $node;
        if (\count($node->args) < 2) {
            return [];
        }
        if (!$node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier || \strtolower($node->name->name) !== 'assertsame') {
            return [];
        }
        $leftType = $scope->getType($node->args[0]->value);
        if (!$leftType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        if ($leftType->getValue()) {
            return ['You should use assertTrue() instead of assertSame() when expecting "true"'];
        }
        return ['You should use assertFalse() instead of assertSame() when expecting "false"'];
    }
}
