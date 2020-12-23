<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
final class StringTypeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isStringOrUnionStringOnlyType(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        if ($nodeType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType) {
            return \true;
        }
        if ($nodeType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            foreach ($nodeType->getTypes() as $singleType) {
                if ($singleType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())->no()) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
