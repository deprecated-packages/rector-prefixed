<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\ChildPopulator;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
abstract class AbstractChildPopulator
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @required
     */
    public function autowireAbstractChildPopulator(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return Name|NullableType|UnionType|null
     */
    protected function resolveChildTypeNode(\PHPStan\Type\Type $type) : ?\PhpParser\Node
    {
        if ($type instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType || $type instanceof \PHPStan\Type\StaticType) {
            $type = new \PHPStan\Type\ObjectType($type->getClassName());
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
    }
}
