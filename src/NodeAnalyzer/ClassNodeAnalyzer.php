<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class ClassNodeAnalyzer
{
    /**
     * @var string
     * @see https://regex101.com/r/FQH6RT/1
     */
    private const ANONYMOUS_CLASS_REGEX = '#AnonymousClass\\w+$#';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isAnonymousClass(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $className = $this->nodeNameResolver->getName($node);
        if ($className === null) {
            return \true;
        }
        // match PHPStan pattern for anonymous classes
        return (bool) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($className, self::ANONYMOUS_CLASS_REGEX);
    }
}
