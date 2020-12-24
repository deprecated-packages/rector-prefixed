<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
final class CallableTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @required
     */
    public function autowireCallableTypeMapper(\_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType::class;
    }
    /**
     * @param CallableType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $returnTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($type->getReturnType());
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareCallableTypeNode(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('callable'), [], $returnTypeNode);
    }
    /**
     * @param CallableType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($kind === 'property') {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('callable');
    }
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        return $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
    }
}
