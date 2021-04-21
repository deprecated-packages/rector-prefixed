<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\TypeAnalyzer;

use PhpParser\Node\Stmt\Property;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
use Rector\Core\ValueObject\Application\RectorError;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\RectorGenerator\Exception\ShouldNotHappenException;
use Rector\Symfony\DataProvider\ServiceMapProvider;
use Rector\Symfony\ValueObject\ServiceMap\ServiceMap;
final class JMSDITypeResolver
{
    /**
     * @var ServiceMapProvider
     */
    private $serviceMapProvider;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CurrentFileProvider
     */
    private $currentFileProvider;
    public function __construct(\Rector\Symfony\DataProvider\ServiceMapProvider $serviceMapProvider, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\Provider\CurrentFileProvider $currentFileProvider)
    {
        $this->serviceMapProvider = $serviceMapProvider;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->currentFileProvider = $currentFileProvider;
    }
    public function resolve(\PhpParser\Node\Stmt\Property $property, \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode $doctrineAnnotationTagValueNode) : \PHPStan\Type\Type
    {
        $serviceMap = $this->serviceMapProvider->provide();
        $serviceName = ($doctrineAnnotationTagValueNode->getValueWithoutQuotes('serviceName') ?: $doctrineAnnotationTagValueNode->getSilentValue()) ?: $this->nodeNameResolver->getName($property);
        if ($serviceName) {
            $serviceType = $this->resolveFromServiceName($serviceName, $serviceMap);
            if (!$serviceType instanceof \PHPStan\Type\MixedType) {
                return $serviceType;
            }
        }
        // 3. service is in @var annotation
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $varType = $phpDocInfo->getVarType();
        if (!$varType instanceof \PHPStan\Type\MixedType) {
            return $varType;
        }
        // the @var is missing and service name was not found → report it
        $this->reportServiceNotFound($serviceName, $property);
        return new \PHPStan\Type\MixedType();
    }
    private function reportServiceNotFound(?string $serviceName, \PhpParser\Node\Stmt\Property $property) : void
    {
        if ($serviceName !== null) {
            return;
        }
        $file = $this->currentFileProvider->getFile();
        if (!$file instanceof \Rector\Core\ValueObject\Application\File) {
            throw new \Rector\RectorGenerator\Exception\ShouldNotHappenException();
        }
        $errorMessage = \sprintf('Service "%s" was not found in DI Container of your Symfony App.', $serviceName);
        $rectorError = new \Rector\Core\ValueObject\Application\RectorError($errorMessage, $property->getLine());
        $file->addRectorError($rectorError);
    }
    private function resolveFromServiceName(string $serviceName, \Rector\Symfony\ValueObject\ServiceMap\ServiceMap $serviceMap) : \PHPStan\Type\Type
    {
        // 1. service name-type
        if ($this->reflectionProvider->hasClass($serviceName)) {
            // single class service
            return new \PHPStan\Type\ObjectType($serviceName);
        }
        // 2. service name
        if ($serviceMap->hasService($serviceName)) {
            $serviceType = $serviceMap->getServiceType($serviceName);
            if ($serviceType !== null) {
                return $serviceType;
            }
        }
        return new \PHPStan\Type\MixedType();
    }
}
