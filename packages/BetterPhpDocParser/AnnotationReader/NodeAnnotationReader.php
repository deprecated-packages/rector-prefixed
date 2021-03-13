<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\AnnotationReader;

use RectorPrefix20210313\Doctrine\Common\Annotations\AnnotationException;
use RectorPrefix20210313\Doctrine\Common\Annotations\Reader;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpPropertyReflection;
use PHPStan\Reflection\ReflectionProvider;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\DoctrineAnnotationGenerated\PhpDocNode\ConstantReferenceIdentifierRestorer;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\DoctrineAnnotationGenerated\PhpDocNode\ConstantReferenceIdentifierRestorer $constantReferenceIdentifierRestorer, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20210313\Doctrine\Common\Annotations\Reader $reader, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reader = $reader;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->constantReferenceIdentifierRestorer = $constantReferenceIdentifierRestorer;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function readAnnotation(\PhpParser\Node $node, string $annotationClass) : ?object
    {
        if ($node instanceof \PhpParser\Node\Stmt\Property) {
            return $this->readPropertyAnnotation($node, $annotationClass);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return $this->readMethodAnnotation($node, $annotationClass);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->readClassAnnotation($node, $annotationClass);
        }
        return null;
    }
    public function readClassAnnotation(\PhpParser\Node\Stmt\Class_ $class, string $annotationClassName) : ?object
    {
        $classReflection = $this->createClassReflectionFromNode($class);
        $nativeClassReflection = $classReflection->getNativeReflection();
        try {
            // covers cases like https://github.com/rectorphp/rector/issues/3046
            /** @var object[] $classAnnotations */
            $classAnnotations = $this->reader->getClassAnnotations($nativeClassReflection);
            return $this->matchNextAnnotation($classAnnotations, $annotationClassName, $class);
        } catch (\RectorPrefix20210313\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
    }
    public function readPropertyAnnotation(\PhpParser\Node\Stmt\Property $property, string $annotationClassName) : ?object
    {
        $reflectionProperty = $this->getNativePropertyReflection($property);
        if (!$reflectionProperty instanceof \ReflectionProperty) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        try {
            // covers cases like https://github.com/rectorphp/rector/issues/3046
            /** @var object[] $propertyAnnotations */
            $propertyAnnotations = $this->reader->getPropertyAnnotations($reflectionProperty);
            return $this->matchNextAnnotation($propertyAnnotations, $annotationClassName, $property);
        } catch (\RectorPrefix20210313\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
    }
    private function readMethodAnnotation(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $annotationClassName) : ?object
    {
        /** @var string $className */
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $reflectionMethod = $this->resolveNativeClassMethodReflection($className, $methodName);
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
        } catch (\RectorPrefix20210313\Doctrine\Common\Annotations\AnnotationException $annotationException) {
            // unable to load
            return null;
        }
        return null;
    }
    private function createClassReflectionFromNode(\PhpParser\Node\Stmt\Class_ $class) : \PHPStan\Reflection\ClassReflection
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        // covers cases like https://github.com/rectorphp/rector/issues/3230#issuecomment-683317288
        return $this->reflectionProvider->getClass($className);
    }
    /**
     * @param object[] $annotations
     */
    private function matchNextAnnotation(array $annotations, string $annotationClassName, \PhpParser\Node $node) : ?object
    {
        foreach ($annotations as $annotation) {
            if (!\is_a($annotation, $annotationClassName, \true)) {
                continue;
            }
            $objectHash = \md5(\spl_object_hash($node) . \serialize($annotation));
            if (\in_array($objectHash, $this->alreadyProvidedAnnotations, \true)) {
                continue;
            }
            $this->alreadyProvidedAnnotations[] = $objectHash;
            $this->constantReferenceIdentifierRestorer->restoreObject($annotation);
            return $annotation;
        }
        return null;
    }
    private function getNativePropertyReflection(\PhpParser\Node\Stmt\Property $property) : ?\ReflectionProperty
    {
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        /** @var string|null $className */
        $className = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            // probably fresh node
            return null;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            // probably fresh node
            return null;
        }
        try {
            $classReflection = $this->reflectionProvider->getClass($className);
            $scope = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            $propertyReflection = $classReflection->getProperty($propertyName, $scope);
            if ($propertyReflection instanceof \PHPStan\Reflection\Php\PhpPropertyReflection) {
                return $propertyReflection->getNativeReflection();
            }
        } catch (\Throwable $throwable) {
            // in case of PHPUnit property or just-added property
            return null;
        }
    }
    private function resolveNativeClassMethodReflection(string $className, string $methodName) : \ReflectionMethod
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        $reflectionClass = $classReflection->getNativeReflection();
        return $reflectionClass->getMethod($methodName);
    }
}
