<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper;
final class IdentifierNodeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var ScalarStringToTypeMapper
     */
    private $scalarStringToTypeMapper;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Mapper\ScalarStringToTypeMapper $scalarStringToTypeMapper)
    {
        $this->scalarStringToTypeMapper = $scalarStringToTypeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier::class;
    }
    /**
     * @param Identifier $node
     */
    public function mapToPHPStan(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->scalarStringToTypeMapper->mapScalarStringToType($node->name);
    }
}
