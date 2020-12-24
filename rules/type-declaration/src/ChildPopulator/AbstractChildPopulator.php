<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ChildPopulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PhpParser\Node\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
abstract class AbstractChildPopulator
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @required
     */
    public function autowireAbstractChildPopulator(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return Name|NullableType|UnionType|null
     */
    protected function resolveChildTypeNode(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return null;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType) {
            $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type->getClassName());
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
    }
}
