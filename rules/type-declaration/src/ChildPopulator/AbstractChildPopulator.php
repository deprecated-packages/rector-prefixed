<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\ChildPopulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
abstract class AbstractChildPopulator
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @required
     */
    public function autowireAbstractChildPopulator(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return Name|NullableType|UnionType|null
     */
    protected function resolveChildTypeNode(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        if ($type instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($type->getClassName());
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
    }
}
