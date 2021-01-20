<?php

declare (strict_types=1);
namespace Rector\Naming\ExpectedNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Naming\Naming\PropertyNaming;
use Rector\Naming\ValueObject\ExpectedName;
final class MatchPropertyTypeExpectedNameResolver extends \Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->propertyNaming = $propertyNaming;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    /**
     * @param Property $node
     */
    public function resolve(\PhpParser\Node $node) : ?string
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $expectedName = $this->propertyNaming->getExpectedNameFromType($phpDocInfo->getVarType());
        if (!$expectedName instanceof \Rector\Naming\ValueObject\ExpectedName) {
            return null;
        }
        return $expectedName->getName();
    }
}
