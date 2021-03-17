<?php

declare (strict_types=1);
namespace Rector\Privatization\Naming;

use PhpParser\Node\Stmt\PropertyProperty;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeNameResolver\NodeNameResolver;
final class ConstantNaming
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createFromProperty(\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : string
    {
        $propertyName = $this->nodeNameResolver->getName($propertyProperty);
        $constantName = \Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($propertyName);
        return \strtoupper($constantName);
    }
}
