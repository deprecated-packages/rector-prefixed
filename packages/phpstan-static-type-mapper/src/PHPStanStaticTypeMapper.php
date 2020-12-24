<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class PHPStanStaticTypeMapper
{
    /**
     * @var string
     */
    public const KIND_PARAM = 'param';
    /**
     * @var string
     */
    public const KIND_PROPERTY = 'property';
    /**
     * @var string
     */
    public const KIND_RETURN = 'return';
    /**
     * @var TypeMapperInterface[]
     */
    private $typeMappers = [];
    /**
     * @param TypeMapperInterface[] $typeMappers
     */
    public function __construct(array $typeMappers)
    {
        foreach ($typeMappers as $typeMapper) {
            if ($typeMapper instanceof \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Contract\PHPStanStaticTypeMapperAwareInterface) {
                $typeMapper->setPHPStanStaticTypeMapper($this);
            }
        }
        $this->typeMappers = $typeMappers;
    }
    public function mapToPHPStanPhpDocTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        foreach ($this->typeMappers as $typeMapper) {
            if (!\is_a($type, $typeMapper->getNodeClass(), \true)) {
                continue;
            }
            return $typeMapper->mapToPHPStanPhpDocTypeNode($type);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($type));
    }
    /**
     * @return Name|NullableType|PhpParserUnionType|null
     */
    public function mapToPhpParserNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->typeMappers as $typeMapper) {
            if (!\is_a($type, $typeMapper->getNodeClass(), \true)) {
                continue;
            }
            return $typeMapper->mapToPhpParserNode($type, $kind);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($type));
    }
    public function mapToDocString(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $parentType = null) : string
    {
        foreach ($this->typeMappers as $typeMapper) {
            if (!\is_a($type, $typeMapper->getNodeClass(), \true)) {
                continue;
            }
            return $typeMapper->mapToDocString($type, $parentType);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedException(__METHOD__ . ' for ' . \get_class($type));
    }
}
