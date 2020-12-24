<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Autodiscovery\Analyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isValueObjectClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        if (isset($this->valueObjectStatusByClassName[$className])) {
            return $this->valueObjectStatusByClassName[$className];
        }
        $constructClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return $this->analyseWithoutConstructor($class, $className);
        }
        // resolve constructor types
        foreach ($constructClassMethod->params as $param) {
            $paramType = $this->nodeTypeResolver->resolve($param);
            if (!$paramType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
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
    private function analyseWithoutConstructor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, ?string $className) : bool
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
    private function hasAllPropertiesWithSerialize(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->stmts as $stmt) {
            if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
                continue;
            }
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $stmt->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                continue;
            }
            if ($phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
                continue;
            }
            return \false;
        }
        return \true;
    }
}
