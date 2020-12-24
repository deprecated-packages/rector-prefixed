<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ChildPopulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
abstract class AbstractChildPopulator
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @required
     */
    public function autowireAbstractChildPopulator(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return Name|NullableType|UnionType|null
     */
    protected function resolveChildTypeNode(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
            $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type->getClassName());
        }
        return $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
    }
}
