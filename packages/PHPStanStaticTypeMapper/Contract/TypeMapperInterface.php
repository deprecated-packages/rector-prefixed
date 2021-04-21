<?php

declare(strict_types=1);

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
    public function getNodeClass(): string;

    public function mapToPHPStanPhpDocTypeNode(Type $type): TypeNode;

    /**
     * @return \PhpParser\Node|null
     * @param string|null $kind
     */
    public function mapToPhpParserNode(Type $type, $kind = null);
}
