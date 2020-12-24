<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
final class BoolPropertyExpectedNameResolver extends \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireBoolPropertyExpectedNameResolver(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        if ($this->nodeTypeResolver->isPropertyBoolean($node)) {
            return $this->propertyNaming->getExpectedNameFromBooleanPropertyType($node);
        }
        return null;
    }
}
