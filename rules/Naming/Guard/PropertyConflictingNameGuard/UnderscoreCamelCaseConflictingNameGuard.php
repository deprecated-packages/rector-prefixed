<?php

declare (strict_types=1);
namespace Rector\Naming\Guard\PropertyConflictingNameGuard;

use PhpParser\Node\Stmt\ClassLike;
use Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
use Rector\Naming\PhpArray\ArrayFilter;
use Rector\Naming\ValueObject\PropertyRename;
use Rector\NodeNameResolver\NodeNameResolver;
final class UnderscoreCamelCaseConflictingNameGuard
{
    /**
     * @var UnderscoreCamelCaseExpectedNameResolver
     */
    private $underscoreCamelCaseExpectedNameResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ArrayFilter
     */
    private $arrayFilter;
    public function __construct(\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Naming\PhpArray\ArrayFilter $arrayFilter)
    {
        $this->underscoreCamelCaseExpectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayFilter = $arrayFilter;
    }
    public function isConflicting(\Rector\Naming\ValueObject\PropertyRename $propertyRename) : bool
    {
        $conflictingPropertyNames = $this->resolve($propertyRename->getClassLike());
        return \in_array($propertyRename->getExpectedName(), $conflictingPropertyNames, \true);
    }
    /**
     * @return string[]
     */
    public function resolve(\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $expectedNames = [];
        foreach ($classLike->getProperties() as $property) {
            $expectedName = $this->underscoreCamelCaseExpectedNameResolver->resolve($property);
            if ($expectedName === null) {
                // fallback to existing name
                $expectedName = $this->nodeNameResolver->getName($property);
            }
            $expectedNames[] = $expectedName;
        }
        return $this->arrayFilter->filterWithAtLeastTwoOccurences($expectedNames);
    }
}
