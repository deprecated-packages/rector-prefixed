<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class TypeWithClassNameTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var StringTypeMapper
     */
    private $stringTypeMapper;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\TypeMapper\StringTypeMapper $stringTypeMapper)
    {
        $this->stringTypeMapper = $stringTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName::class;
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('string-class');
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->stringTypeMapper->mapToPhpParserNode($type, $kind);
    }
    /**
     * @param TypeWithClassName $type
     */
    public function mapToDocString(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
