<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
abstract class AbstractExpectedNameResolver implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver\ExpectedNameResolverInterface
{
    /**
     * @var NodeTypeResolver
     */
    protected $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param Param|Property $node
     */
    public function resolveIfNotYet(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
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
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($currentName, $suffixNamePattern);
    }
}
