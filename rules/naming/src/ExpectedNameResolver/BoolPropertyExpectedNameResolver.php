<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming;
final class BoolPropertyExpectedNameResolver extends \_PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireBoolPropertyExpectedNameResolver(\_PhpScoper0a2ac50786fa\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        if ($this->nodeTypeResolver->isPropertyBoolean($node)) {
            return $this->propertyNaming->getExpectedNameFromBooleanPropertyType($node);
        }
        return null;
    }
}
