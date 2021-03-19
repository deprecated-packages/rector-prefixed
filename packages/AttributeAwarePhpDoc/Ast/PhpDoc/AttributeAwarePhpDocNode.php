<?php

declare (strict_types=1);
namespace Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\NodeAttributes;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use RectorPrefix20210319\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
final class AttributeAwarePhpDocNode extends \RectorPrefix20210319\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
{
    use NodeAttributes;
    /**
     * @var array<PhpDocChildNode>
     */
    public $children = [];
    public function __toString() : string
    {
        return "/**\n * " . \implode("\n * ", $this->children) . "\n */";
    }
}
