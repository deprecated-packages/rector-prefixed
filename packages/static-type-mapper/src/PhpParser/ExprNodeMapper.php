<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class ExprNodeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    /**
     * @param Expr $node
     */
    public function mapToPHPStan(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $scope->getType($node);
    }
}
