<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class MatchPropertyTypeExpectedNameResolver extends \_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @required
     */
    public function autowireMatchPropertyTypeExpectedNameResolver(\_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Property $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
