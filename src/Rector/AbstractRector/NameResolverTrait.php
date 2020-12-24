<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait NameResolverTrait
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @required
     */
    public function autowireNameResolverTrait(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming $classNaming) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function isName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isName($node, $name);
    }
    public function areNamesEqual(\_PhpScoper0a6b37af0871\PhpParser\Node $firstNode, \_PhpScoper0a6b37af0871\PhpParser\Node $secondNode) : bool
    {
        return $this->nodeNameResolver->areNamesEqual($firstNode, $secondNode);
    }
    /**
     * @param string[] $names
     */
    public function isNames(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isNames($node, $names);
    }
    public function getName(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        return $this->nodeNameResolver->getName($node);
    }
    /**
     * @param string|Name|Identifier|ClassLike $name
     */
    protected function getShortName($name) : string
    {
        return $this->classNaming->getShortName($name);
    }
    protected function isLocalPropertyFetchNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        return $this->nodeNameResolver->isLocalPropertyFetchNamed($node, $name);
    }
    protected function isLocalMethodCallNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isName($node->var, 'this')) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    /**
     * @param string[] $names
     */
    protected function isLocalMethodCallsNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $names) : bool
    {
        foreach ($names as $name) {
            if ($this->isLocalMethodCallNamed($node, $name)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isFuncCallName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($node, $name);
    }
    /**
     * Detects "SomeClass::class"
     */
    protected function isClassConstReference(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $className) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            return \false;
        }
        if (!$this->isName($node->name, 'class')) {
            return \false;
        }
        return $this->isName($node->class, $className);
    }
    protected function isStaticCallNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $className, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        // handles (new Some())->...
        if ($node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            if (!$this->isObjectType($node->class, $className)) {
                return \false;
            }
        } elseif (!$this->isName($node->class, $className)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @param string[] $methodNames
     */
    protected function isStaticCallsNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $className, array $methodNames) : bool
    {
        foreach ($methodNames as $methodName) {
            if ($this->isStaticCallNamed($node, $className, $methodName)) {
                return \true;
            }
        }
        return \false;
    }
    protected function isMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $variableName, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->isName($node->var, $variableName)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    protected function isVariableName(?\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->isName($node, $name);
    }
    protected function isInClassNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $desiredClassName) : bool
    {
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        return \is_a($className, $desiredClassName, \true);
    }
    /**
     * @param string[] $desiredClassNames
     */
    protected function isInClassesNamed(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $desiredClassNames) : bool
    {
        foreach ($desiredClassNames as $desiredClassName) {
            if ($this->isInClassNamed($node, $desiredClassName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param string[] $names
     */
    protected function isFuncCallNames(\_PhpScoper0a6b37af0871\PhpParser\Node $node, array $names) : bool
    {
        return $this->nodeNameResolver->isFuncCallNames($node, $names);
    }
}
