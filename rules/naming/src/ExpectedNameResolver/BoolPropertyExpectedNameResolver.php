<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
final class BoolPropertyExpectedNameResolver extends \_PhpScoper2a4e7ab1ecbc\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireBoolPropertyExpectedNameResolver(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if ($this->nodeTypeResolver->isPropertyBoolean($node)) {
            return $this->propertyNaming->getExpectedNameFromBooleanPropertyType($node);
        }
        return null;
    }
}
