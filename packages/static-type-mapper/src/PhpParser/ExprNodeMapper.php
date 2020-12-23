<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class ExprNodeMapper implements \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr::class;
    }
    /**
     * @param Expr $node
     */
    public function mapToPHPStan(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return $scope->getType($node);
    }
}
