<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\StaticTypeMapper\ValueObject\Type\ParentStaticType;
final class ParentStaticTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \Rector\StaticTypeMapper\ValueObject\Type\ParentStaticType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('parent');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode($type, $kind = null)
    {
        return new \PhpParser\Node\Name('parent');
    }
}
