<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\Contract;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
interface TypeMapperInterface
{
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string;
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode;
    /**
     * @return \PhpParser\Node|null
     * @param string|null $kind
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPhpParserNode($type, $kind = null);
}
