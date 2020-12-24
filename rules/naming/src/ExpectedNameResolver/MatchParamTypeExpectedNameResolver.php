<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
final class MatchParamTypeExpectedNameResolver extends \_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @required
     */
    public function autowireMatchParamTypeExpectedNameResolver(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        // nothing to verify
        if ($node->type === null) {
            return null;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($node->type);
        $expectedName = $this->propertyNaming->getExpectedNameFromType($staticType);
        if ($expectedName === null) {
            return null;
        }
        return $expectedName->getName();
    }
}
