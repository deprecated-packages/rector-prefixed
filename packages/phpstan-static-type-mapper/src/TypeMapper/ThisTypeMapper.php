<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareThisTypeNode;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class ThisTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType::class;
    }
    /**
     * @param ThisType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareThisTypeNode();
    }
    /**
     * @param ThisType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self');
    }
    /**
     * @param ThisType $type
     */
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
