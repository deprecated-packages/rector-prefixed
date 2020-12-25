<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\NeverType;
use PHPStan\Type\Type;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class NeverTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \PHPStan\Type\NeverType::class;
    }
    /**
     * @param NeverType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('mixed');
    }
    /**
     * @param NeverType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        return null;
    }
    public function mapToDocString(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $parentType = null) : string
    {
        return 'mixed';
    }
}
