<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
final class StringTypeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isStringOrUnionStringOnlyType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->getStaticType($node);
        if ($nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
            return \true;
        }
        if ($nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            foreach ($nodeType->getTypes() as $singleType) {
                if ($singleType->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->no()) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
