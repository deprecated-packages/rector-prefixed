<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Analyzer;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeCollector\NodeCollector\NodeRepository;
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
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->nodeRepository = $nodeRepository;
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
        if (!$constructClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
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
            $paramTypeClass = $this->nodeRepository->findClass($paramType->getClassName());
            if (!$paramTypeClass instanceof \PhpParser\Node\Stmt\Class_) {
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
        foreach ($class->getProperties() as $property) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            if ($phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
