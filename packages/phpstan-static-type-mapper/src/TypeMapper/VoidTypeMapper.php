<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\TypeMapper;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class VoidTypeMapper implements \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var string
     */
    private const VOID = 'void';
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function getNodeClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType::class;
    }
    /**
     * @param VoidType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode(self::VOID);
    }
    /**
     * @param VoidType $type
     */
    public function mapToPhpParserNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::VOID_TYPE)) {
            return null;
        }
        if (\in_array($kind, ['param', 'property'], \true)) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::VOID);
    }
    public function mapToDocString(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $parentType = null) : string
    {
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::SCALAR_TYPES)) {
            // the void type is better done in PHP code
            return '';
        }
        // fallback for PHP 7.0 and older, where void type was only in docs
        return self::VOID;
    }
}
