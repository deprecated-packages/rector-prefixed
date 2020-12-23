<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\PhpDocParser;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface;
final class GenericTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\Contract\PhpDocParser\PhpDocTypeMapperInterface
{
    /**
     * @var TypeNodeResolver
     */
    private $typeNodeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver)
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode::class;
    }
    public function mapToPHPStanType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->typeNodeResolver->resolve($typeNode, $nameScope);
    }
}
