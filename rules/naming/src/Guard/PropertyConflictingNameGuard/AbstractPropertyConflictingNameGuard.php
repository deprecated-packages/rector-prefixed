<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\PhpArray\ArrayFilter;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
abstract class AbstractPropertyConflictingNameGuard implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var ExpectedNameResolverInterface
     */
    protected $expectedNameResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ArrayFilter
     */
    private $arrayFilter;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Naming\PhpArray\ArrayFilter $arrayFilter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayFilter = $arrayFilter;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        $conflictingPropertyNames = $this->resolve($renameValueObject->getClassLike());
        return \in_array($renameValueObject->getExpectedName(), $conflictingPropertyNames, \true);
    }
    /**
     * @param ClassLike $node
     * @return string[]
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $expectedNames = [];
        foreach ($node->getProperties() as $property) {
            $expectedName = $this->expectedNameResolver->resolve($property);
            if ($expectedName === null) {
                /** @var string $expectedName */
                $expectedName = $this->nodeNameResolver->getName($property);
            }
            $expectedNames[] = $expectedName;
        }
        return $this->arrayFilter->filterWithAtLeastTwoOccurences($expectedNames);
    }
}
