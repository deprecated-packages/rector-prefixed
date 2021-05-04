<?php

declare (strict_types=1);
namespace Rector\Privatization\Naming;

use PhpParser\Node\Stmt\PropertyProperty;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210504\Stringy\Stringy;
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
        $stringy = new \RectorPrefix20210504\Stringy\Stringy($propertyName);
        return (string) $stringy->underscored()->toUpperCase();
    }
}
