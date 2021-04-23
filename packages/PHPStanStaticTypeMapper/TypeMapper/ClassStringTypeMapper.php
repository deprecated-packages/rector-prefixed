<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class ClassStringTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface, \Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ClassStringType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $attributeAwareIdentifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('class-string');
        if ($type instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof \PHPStan\Type\ObjectType) {
                $className = $genericType->getClassName();
                $className = $this->normalizeType($className);
                $genericType = new \PHPStan\Type\ObjectType($className);
            }
            $genericTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
            return new \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode($attributeAwareIdentifierTypeNode, [$genericTypeNode]);
        }
        return $attributeAwareIdentifierTypeNode;
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
    /**
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     * @return void
     */
    public function setPHPStanStaticTypeMapper($phpStanStaticTypeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    private function normalizeType(string $classType) : string
    {
        if (\is_a($classType, \PhpParser\Node\Expr::class, \true)) {
            return \PhpParser\Node\Expr::class;
        }
        if (\is_a($classType, \PhpParser\Node::class, \true)) {
            return \PhpParser\Node::class;
        }
        return $classType;
    }
}
