<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return mixed[]
     */
    public function resolveClassMocksFromParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $className = $this->nodeNameResolver->getName($class);
        if (isset($this->mocks[$className])) {
            return $this->mocks[$className];
        }
        $this->callableNodeTraverser->traverseNodesWithCallable($class, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
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
    public function isVariableMockInProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $variableName = $this->nodeNameResolver->getName($variable);
        $className = $variable->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return \in_array($variableName, $this->propertyMocksByClass[$className] ?? [], \true);
    }
    public function getTypeForClassAndVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $variable) : string
    {
        $className = $this->nodeNameResolver->getName($class);
        if (!isset($this->mocksWithsTypes[$className][$variable])) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $this->mocksWithsTypes[$className][$variable];
    }
    public function addPropertyMock(string $class, string $property) : void
    {
        $this->propertyMocksByClass[$class][] = $property;
    }
    private function addMockFromParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : void
    {
        $variable = $this->nodeNameResolver->getName($param->var);
        /** @var string $class */
        $class = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $this->mocks[$class][$variable][] = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($param->type === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $paramType = (string) ($param->type->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME) ?: $param->type);
        $this->mocksWithsTypes[$class][$variable] = $paramType;
    }
}
