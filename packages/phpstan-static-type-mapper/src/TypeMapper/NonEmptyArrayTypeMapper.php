<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class NonEmptyArrayTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType::class;
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode(new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('mixed'));
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('array');
    }
    /**
     * @param NonEmptyArrayType $type
     */
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        return 'mixed[]';
    }
}
