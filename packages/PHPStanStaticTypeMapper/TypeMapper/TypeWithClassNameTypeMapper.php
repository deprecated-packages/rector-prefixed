<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\VerbosityLevel;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class TypeWithClassNameTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var StringTypeMapper
     */
    private $stringTypeMapper;
    public function __construct(\Rector\PHPStanStaticTypeMapper\TypeMapper\StringTypeMapper $stringTypeMapper)
    {
        $this->stringTypeMapper = $stringTypeMapper;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\TypeWithClassName::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('string-class');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     */
    public function mapToPhpParserNode($type, $kind = null) : ?\PhpParser\Node
    {
        return $this->stringTypeMapper->mapToPhpParserNode($type, $kind);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString($type, $parentType = null) : string
    {
        return $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
