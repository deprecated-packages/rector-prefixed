<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\TypeMapper;

use Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class ClosureTypeMapper implements \_PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType::class;
    }
    /**
     * @param ClosureType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException();
    }
    /**
     * @param ClosureType $type
     */
    public function mapToPhpParserNode(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($kind === 'property') {
            return null;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('callable');
    }
    public function mapToDocString(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $parentType = null) : string
    {
        return '\\' . \Closure::class;
    }
}
