<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Type;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType;
final class BooleanTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \PHPStan\Type\BooleanType::class;
    }
    /**
     * @param BooleanType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($this->isFalseBooleanTypeWithUnion($type)) {
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('false');
        }
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('bool');
    }
    /**
     * @param BooleanType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            return null;
        }
        if ($this->isFalseBooleanTypeWithUnion($type)) {
            return new \PhpParser\Node\Name('false');
        }
        return new \PhpParser\Node\Name('bool');
    }
    /**
     * @param BooleanType $type
     */
    public function mapToDocString(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->isFalseBooleanTypeWithUnion($type)) {
            return 'false';
        }
        return 'bool';
    }
    private function isFalseBooleanTypeWithUnion(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \Rector\StaticTypeMapper\ValueObject\Type\FalseBooleanType) {
            return \false;
        }
        return $this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES);
    }
}
