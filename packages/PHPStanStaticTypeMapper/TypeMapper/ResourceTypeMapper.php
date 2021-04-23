<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ResourceType;
use PHPStan\Type\Type;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class ResourceTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ResourceType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('resource');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode($type, $kind = null)
    {
        return null;
    }
}
