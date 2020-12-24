<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
abstract class AbstractExpectedNameResolver implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param Param|Property $node
     */
    public function resolveIfNotYet(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        $expectedName = $this->resolve($node);
        if ($expectedName === null) {
            return null;
        }
        /** @var string $currentName */
        $currentName = $this->nodeNameResolver->getName($node);
        if ($this->endsWith($currentName, $expectedName)) {
            return null;
        }
        if ($this->nodeNameResolver->isName($node, $expectedName)) {
            return null;
        }
        return $expectedName;
    }
    /**
     * Ends with ucname
     * Starts with adjective, e.g. (Post $firstPost, Post $secondPost)
     */
    protected function endsWith(string $currentName, string $expectedName) : bool
    {
        $suffixNamePattern = '#\\w+' . \ucfirst($expectedName) . '#';
        return (bool) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($currentName, $suffixNamePattern);
    }
}
