<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class MatchPropertyTypeExpectedNameResolver extends \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireMatchPropertyTypeExpectedNameResolver(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $expectedName = $this->propertyNaming->getExpectedNameFromType($phpDocInfo->getVarType());
        if ($expectedName === null) {
            return null;
        }
        return $expectedName->getName();
    }
}
