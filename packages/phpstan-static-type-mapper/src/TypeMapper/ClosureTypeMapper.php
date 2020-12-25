<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use Closure;
use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ClosureType;
use PHPStan\Type\Type;
use Rector\Core\Exception\NotImplementedException;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
final class ClosureTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ClosureType::class;
    }
    /**
     * @param ClosureType $type
     */
    public function mapToPHPStanPhpDocTypeNode(\PHPStan\Type\Type $type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        throw new \Rector\Core\Exception\NotImplementedException();
    }
    /**
     * @param ClosureType $type
     */
    public function mapToPhpParserNode(\PHPStan\Type\Type $type, ?string $kind = null) : ?\PhpParser\Node
    {
        if ($kind === 'property') {
            return null;
        }
        return new \PhpParser\Node\Name('callable');
    }
    public function mapToDocString(\PHPStan\Type\Type $type, ?\PHPStan\Type\Type $parentType = null) : string
    {
        return '\\' . \Closure::class;
    }
}
