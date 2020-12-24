<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
final class MatchParamTypeExpectedNameResolver extends \_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
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
    public function autowireMatchParamTypeExpectedNameResolver(\_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
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
