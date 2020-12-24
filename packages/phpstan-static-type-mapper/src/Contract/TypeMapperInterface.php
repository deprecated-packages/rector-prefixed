<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStanStaticTypeMapper\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface TypeMapperInterface
{
    public function getNodeClass() : string;
    public function mapToPHPStanPhpDocTypeNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
    /**
     * @return Name|NullableType|UnionType|null
     */
    public function mapToPhpParserNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?string $kind = null) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node;
    public function mapToDocString(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $parentType = null) : string;
}
