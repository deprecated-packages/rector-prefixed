<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\TypeAnalyzer;

use PhpParser\Node\Stmt\Property;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Symfony\DataProvider\ServiceMapProvider;
use Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode;
use RectorPrefix20210326\Symplify\SmartFileSystem\SmartFileInfo;
final class JMSDITypeResolver
{
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
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
    public function __construct(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector, \Rector\Symfony\DataProvider\ServiceMapProvider $serviceMapProvider, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->errorAndDiffCollector = $errorAndDiffCollector;
        $this->serviceMapProvider = $serviceMapProvider;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function resolve(\PhpParser\Node\Stmt\Property $property, \Rector\Symfony\PhpDoc\Node\JMS\JMSInjectTagValueNode $jmsInjectTagValueNode) : \PHPStan\Type\Type
    {
        $serviceMap = $this->serviceMapProvider->provide();
        $serviceName = $jmsInjectTagValueNode->getServiceName();
        if ($serviceName) {
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
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        $errorMessage = \sprintf('Service "%s" was not found in DI Container of your Symfony App.', $serviceName);
        $this->errorAndDiffCollector->addErrorWithRectorClassMessageAndFileInfo(self::class, $errorMessage, $fileInfo);
    }
}
