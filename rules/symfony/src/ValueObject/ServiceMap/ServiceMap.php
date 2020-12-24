<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony\ValueObject\ServiceMap;

use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Symfony\ValueObject\ServiceDefinition;
final class ServiceMap
{
    /**
     * @var ServiceDefinition[]
     */
    private $services = [];
    /**
     * @param ServiceDefinition[] $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }
    public function hasService(string $id) : bool
    {
        return isset($this->services[$id]);
    }
    public function getServiceType(string $id) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $serviceDefinition = $this->getService($id);
        if ($serviceDefinition === null) {
            return null;
        }
        $class = $serviceDefinition->getClass();
        if ($class === null) {
            return null;
        }
        /** @var string[] $interfaces */
        $interfaces = (array) \class_implements($class);
        foreach ($interfaces as $interface) {
            // return first interface
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($interface);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($class);
    }
    /**
     * @return ServiceDefinition[]
     */
    public function getServicesByTag(string $tagName) : array
    {
        $servicesWithTag = [];
        foreach ($this->services as $service) {
            foreach ($service->getTags() as $tag) {
                if ($tag->getName() !== $tagName) {
                    continue;
                }
                $servicesWithTag[] = $service;
                continue 2;
            }
        }
        return $servicesWithTag;
    }
    private function getService(string $id) : ?\_PhpScoperb75b35f52b74\Rector\Symfony\ValueObject\ServiceDefinition
    {
        return $this->services[$id] ?? null;
    }
}
