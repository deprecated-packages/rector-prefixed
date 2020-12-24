<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\AnnotationReader;

use _PhpScopere8e811afab72\Doctrine\Common\Annotations\AnnotationException;
use _PhpScopere8e811afab72\Doctrine\Common\Annotations\Reader;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\DoctrineAnnotationGenerated\PhpDocNode\ConstantReferenceIdentifierRestorer;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Throwable;
final class NodeAnnotationReader
{
    /**
     * @var string[]
     */
    private $alreadyProvidedAnnotations = [];
    /**
     * @var Reader
     */
    private $reader;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ConstantReferenceIdentifierRestorer
     */
    private $constantReferenceIdentifierRestorer;
    public function __construct(\_PhpScopere8e811afab72\Rector\DoctrineAnnotationGenerated\PhpDocNode\ConstantReferenceIdentifierRestorer $constantReferenceIdentifierRestorer, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Doctrine\Common\Annotations\Reader $reader)
    {
        $this->reader = $reader;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->constantReferenceIdentifierRestorer = $constantReferenceIdentifierRestorer;
    }
    public function readAnnotation(\_PhpScopere8e811afab72\PhpParser\Node $node, string $annotationClass) : ?object
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
            return $this->readPropertyAnnotation($node, $annotationClass);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return $this->readMethodAnnotation($node, $annotationClass);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->readClassAnnotation($node, $annotationClass);
        }
        return null;
    }
    public function readClassAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $annotationClassName) : ?object
    {
        $classReflection = $this->createClassReflectionFromNode($class);
        try {
            // covers cases like https://github.com/rectorphp/rector/issues/3046
            /** @var object[] $classAnnotations */
            $classAnnotations = $this->reader->getClassAnnotations($classReflection);
            return $this->matchNextAnnotation($classAnnotations, $annotationClassName, $class);
        } catch (\_PhpScopere8e811afab72\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
    }
    public function readPropertyAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, string $annotationClassName) : ?object
    {
        $propertyReflection = $this->createPropertyReflectionFromPropertyNode($property);
        if ($propertyReflection === null) {
            return null;
        }
        try {
            // covers cases like https://github.com/rectorphp/rector/issues/3046
            /** @var object[] $propertyAnnotations */
            $propertyAnnotations = $this->reader->getPropertyAnnotations($propertyReflection);
            return $this->matchNextAnnotation($propertyAnnotations, $annotationClassName, $property);
        } catch (\_PhpScopere8e811afab72\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
    }
    private function readMethodAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $annotationClassName) : ?object
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $reflectionMethod = new \ReflectionMethod($className, $methodName);
        try {
            // covers cases like https://github.com/rectorphp/rector/issues/3046
            /** @var object[] $methodAnnotations */
            $methodAnnotations = $this->reader->getMethodAnnotations($reflectionMethod);
            foreach ($methodAnnotations as $methodAnnotation) {
                if (!\is_a($methodAnnotation, $annotationClassName, \true)) {
                    continue;
                }
                $objectHash = \md5(\spl_object_hash($classMethod) . \serialize($methodAnnotation));
                if (\in_array($objectHash, $this->alreadyProvidedAnnotations, \true)) {
                    continue;
                }
                $this->alreadyProvidedAnnotations[] = $objectHash;
                $this->constantReferenceIdentifierRestorer->restoreObject($methodAnnotation);
                return $methodAnnotation;
            }
        } catch (\_PhpScopere8e811afab72\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
        return null;
    }
    private function createClassReflectionFromNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : \ReflectionClass
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        // covers cases like https://github.com/rectorphp/rector/issues/3230#issuecomment-683317288
        return new \ReflectionClass($className);
    }
    /**
     * @param object[] $annotations
     */
    private function matchNextAnnotation(array $annotations, string $annotationClassName, \_PhpScopere8e811afab72\PhpParser\Node $node) : ?object
    {
        foreach ($annotations as $annotatoin) {
            if (!\is_a($annotatoin, $annotationClassName, \true)) {
                continue;
            }
            $objectHash = \md5(\spl_object_hash($node) . \serialize($annotatoin));
            if (\in_array($objectHash, $this->alreadyProvidedAnnotations, \true)) {
                continue;
            }
            $this->alreadyProvidedAnnotations[] = $objectHash;
            $this->constantReferenceIdentifierRestorer->restoreObject($annotatoin);
            return $annotatoin;
        }
        return null;
    }
    private function createPropertyReflectionFromPropertyNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\ReflectionProperty
    {
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        /** @var string|null $className */
        $className = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null || !\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
            // probably fresh node
            return null;
        }
        try {
            return new \ReflectionProperty($className, $propertyName);
        } catch (\Throwable $throwable) {
            // in case of PHPUnit property or just-added property
            return null;
        }
    }
}
