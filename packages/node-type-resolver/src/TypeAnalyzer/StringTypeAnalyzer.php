<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class StringTypeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isStringOrUnionStringOnlyType(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        if ($nodeType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            return \true;
        }
        if ($nodeType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            foreach ($nodeType->getTypes() as $singleType) {
                if ($singleType->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType())->no()) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
