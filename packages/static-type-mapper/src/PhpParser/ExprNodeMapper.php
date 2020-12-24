<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpParser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class ExprNodeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    /**
     * @param Expr $node
     */
    public function mapToPHPStan(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $scope->getType($node);
    }
}
