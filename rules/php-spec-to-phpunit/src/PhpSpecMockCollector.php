<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class PhpSpecMockCollector
{
    /**
     * @var mixed[]
     */
    private $mocks = [];
    /**
     * @var mixed[]
     */
    private $mocksWithsTypes = [];
    /**
     * @var mixed[]
     */
    private $propertyMocksByClass = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return mixed[]
     */
    public function resolveClassMocksFromParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $className = $this->nodeNameResolver->getName($class);
        if (isset($this->mocks[$className])) {
            return $this->mocks[$className];
        }
        $this->callableNodeTraverser->traverseNodesWithCallable($class, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
                return;
            }
            if (!$node->isPublic()) {
                return;
            }
            foreach ($node->params as $param) {
                $this->addMockFromParam($param);
            }
        });
        // set default value if none was found
        if (!isset($this->mocks[$className])) {
            $this->mocks[$className] = [];
        }
        return $this->mocks[$className];
    }
    public function isVariableMockInProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $variableName = $this->nodeNameResolver->getName($variable);
        $className = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return \in_array($variableName, $this->propertyMocksByClass[$className] ?? [], \true);
    }
    public function getTypeForClassAndVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $variable) : string
    {
        $className = $this->nodeNameResolver->getName($class);
        if (!isset($this->mocksWithsTypes[$className][$variable])) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->mocksWithsTypes[$className][$variable];
    }
    public function addPropertyMock(string $class, string $property) : void
    {
        $this->propertyMocksByClass[$class][] = $property;
    }
    private function addMockFromParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : void
    {
        $variable = $this->nodeNameResolver->getName($param->var);
        /** @var string $class */
        $class = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $this->mocks[$class][$variable][] = $param->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($param->type === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $paramType = (string) ($param->type->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME) ?: $param->type);
        $this->mocksWithsTypes[$class][$variable] = $paramType;
    }
}
