<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
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
        return new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('string-class');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     * @return \PhpParser\Node|null
     */
    public function mapToPhpParserNode($type, $kind = null)
    {
        return $this->stringTypeMapper->mapToPhpParserNode($type, $kind);
    }
}
