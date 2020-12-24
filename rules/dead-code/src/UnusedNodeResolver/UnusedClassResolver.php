<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\UnusedNodeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class UnusedClassResolver
{
    /**
     * @var string[]
     */
    private $cachedUsedClassNames = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    public function isClassWithoutInterfaceAndNotController(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->implements !== []) {
            return \false;
        }
        if ($class->extends !== null) {
            return \false;
        }
        if ($this->nodeNameResolver->isNames($class, ['*Controller', '*Presenter'])) {
            return \false;
        }
        return !$this->nodeNameResolver->isName($class, '*Test');
    }
    public function isClassUsed(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return $this->nodeNameResolver->isNames($class, $this->getUsedClassNames());
    }
    /**
     * @return string[]
     */
    private function getUsedClassNames() : array
    {
        if (!\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun() && $this->cachedUsedClassNames !== []) {
            return $this->cachedUsedClassNames;
        }
        $cachedUsedClassNames = \array_merge($this->getParamNodesClassNames(), $this->getNewNodesClassNames(), $this->getStaticCallClassNames(), $this->getClassConstantFetchNames());
        $cachedUsedClassNames = $this->sortAndUniqueArray($cachedUsedClassNames);
        /** @var string[] $cachedUsedClassNames */
        $this->cachedUsedClassNames = $cachedUsedClassNames;
        return $this->cachedUsedClassNames;
    }
    /**
     * @return string[]
     */
    private function getParamNodesClassNames() : array
    {
        $classNames = [];
        foreach ($this->parsedNodeCollector->getParams() as $param) {
            if ($param->type === null) {
                continue;
            }
            if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
                $param = $param->type;
            }
            if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                continue;
            }
            if ($param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                /** @var string $paramTypeName */
                $paramTypeName = $this->nodeNameResolver->getName($param->type);
                $classNames[] = $paramTypeName;
            } else {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException();
            }
        }
        return $classNames;
    }
    /**
     * @return string[]
     */
    private function getNewNodesClassNames() : array
    {
        $classNames = [];
        foreach ($this->parsedNodeCollector->getNews() as $newNode) {
            $newClassName = $this->nodeNameResolver->getName($newNode->class);
            if (!\is_string($newClassName)) {
                continue;
            }
            $classNames[] = $newClassName;
        }
        return $classNames;
    }
    /**
     * @return string[]
     */
    private function getStaticCallClassNames() : array
    {
        $classNames = [];
        foreach ($this->parsedNodeCollector->getStaticCalls() as $staticCallNode) {
            $staticClassName = $this->nodeNameResolver->getName($staticCallNode->class);
            if (!\is_string($staticClassName)) {
                continue;
            }
            $classNames[] = $staticClassName;
        }
        return $classNames;
    }
    /**
     * @return string[]
     */
    private function getClassConstantFetchNames() : array
    {
        $classConstFetches = $this->parsedNodeCollector->getClassConstFetches();
        $classNames = [];
        foreach ($classConstFetches as $classConstFetch) {
            $className = $this->nodeNameResolver->getName($classConstFetch->class);
            if (!\is_string($className)) {
                continue;
            }
            $classNames[] = $className;
        }
        return $classNames;
    }
    /**
     * @param string[] $items
     * @return string[]
     */
    private function sortAndUniqueArray(array $items) : array
    {
        \sort($items);
        return \array_unique($items);
    }
}
