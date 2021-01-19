<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Analyzer;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassAnalyzer
{
    /**
     * @var bool[]
     */
    private $valueObjectStatusByClassName = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function isValueObjectClass(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        if (isset($this->valueObjectStatusByClassName[$className])) {
            return $this->valueObjectStatusByClassName[$className];
        }
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return $this->analyseWithoutConstructor($class, $className);
        }
        // resolve constructor types
        foreach ($constructClassMethod->params as $param) {
            $paramType = $this->nodeTypeResolver->resolve($param);
            if (!$paramType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            // awesome!
            // is it services or value object?
            $paramTypeClass = $this->parsedNodeCollector->findClass($paramType->getClassName());
            if ($paramTypeClass === null) {
                // not sure :/
                continue;
            }
            if (!$this->isValueObjectClass($paramTypeClass)) {
                return \false;
            }
        }
        // if we didn't prove it's not a value object so far → fallback to true
        $this->valueObjectStatusByClassName[$className] = \true;
        return \true;
    }
    private function analyseWithoutConstructor(\PhpParser\Node\Stmt\Class_ $class, ?string $className) : bool
    {
        // A. has all properties with serialize?
        if ($this->hasAllPropertiesWithSerialize($class)) {
            $this->valueObjectStatusByClassName[$className] = \true;
            return \true;
        }
        // probably not a value object
        $this->valueObjectStatusByClassName[$className] = \false;
        return \false;
    }
    private function hasAllPropertiesWithSerialize(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->stmts as $stmt) {
            if (!$stmt instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($stmt);
            if ($phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
