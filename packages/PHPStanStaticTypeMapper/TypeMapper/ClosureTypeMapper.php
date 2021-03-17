<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use Closure;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ClosureType;
use PHPStan\Type\Type;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode;
use Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ClosureTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var CallableTypeMapper
     */
    private $callableTypeMapper;
    public function __construct(\Rector\PHPStanStaticTypeMapper\TypeMapper\CallableTypeMapper $callableTypeMapper)
    {
        $this->callableTypeMapper = $callableTypeMapper;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ClosureType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($type->getClassName());
        $returnDocTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getReturnType());
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode($identifierTypeNode, [], $returnDocTypeNode);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     */
    public function mapToPhpParserNode($type, $kind = null) : ?\PhpParser\Node
    {
        return $this->callableTypeMapper->mapToPhpParserNode($type, $kind);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString($type, $parentType = null) : string
    {
        return '\\' . \Closure::class;
    }
    /**
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     */
    public function setPHPStanStaticTypeMapper($phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
}
