<?php

declare (strict_types=1);
namespace Rector\Naming\ExpectedNameResolver;

use PhpParser\Node;
use PhpParser\Node\Param;
use Rector\Naming\Naming\PropertyNaming;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class MatchParamTypeExpectedNameResolver extends \Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
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
    public function autowireMatchParamTypeExpectedNameResolver(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\Naming\Naming\PropertyNaming $propertyNaming) : void
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->propertyNaming = $propertyNaming;
    }
    /**
     * @param Param $node
     */
    public function resolve(\PhpParser\Node $node) : ?string
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
