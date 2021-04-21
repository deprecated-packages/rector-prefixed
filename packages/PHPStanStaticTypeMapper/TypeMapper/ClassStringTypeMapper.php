<?php

declare(strict_types=1);

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

final class ClassStringTypeMapper implements TypeMapperInterface, PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;

    /**
     * @return class-string<Type>
     */
    public function getNodeClass(): string
    {
        return ClassStringType::class;
    }

    /**
     * @param ClassStringType $type
     */
    public function mapToPHPStanPhpDocTypeNode(Type $type): TypeNode
    {
        $attributeAwareIdentifierTypeNode = new IdentifierTypeNode('class-string');

        if ($type instanceof GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof ObjectType) {
                $className = $genericType->getClassName();
                $className = $this->normalizeType($className);
                $genericType = new ObjectType($className);
            }

            $genericTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericType);
            return new GenericTypeNode($attributeAwareIdentifierTypeNode, [$genericTypeNode]);
        }

        return $attributeAwareIdentifierTypeNode;
    }

    /**
     * @param ClassStringType $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode(Type $type, $kind = null)
    {
        return null;
    }

    /**
     * @return void
     */
    public function setPHPStanStaticTypeMapper(PHPStanStaticTypeMapper $phpStanStaticTypeMapper)
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }

    private function normalizeType(string $classType): string
    {
        if (is_a($classType, Expr::class, true)) {
            return Expr::class;
        }

        if (is_a($classType, Node::class, true)) {
            return Node::class;
        }

        return $classType;
    }
}
