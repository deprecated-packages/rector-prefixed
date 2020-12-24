<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class MatchParamTypeExpectedNameResolver extends \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
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
    public function autowireMatchParamTypeExpectedNameResolver(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
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
