<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
final class BoolPropertyExpectedNameResolver extends \_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireBoolPropertyExpectedNameResolver(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if ($this->nodeTypeResolver->isPropertyBoolean($node)) {
            return $this->propertyNaming->getExpectedNameFromBooleanPropertyType($node);
        }
        return null;
    }
}
