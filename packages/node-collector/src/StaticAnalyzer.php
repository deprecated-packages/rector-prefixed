<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeCollector;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use ReflectionClass;
final class StaticAnalyzer
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    public function isStaticMethod(string $methodName, string $className) : bool
    {
        $classMethod = $this->nodeRepository->findClassMethod($className, $methodName);
        if ($classMethod !== null) {
            return $classMethod->isStatic();
        }
        // could be static in doc type magic
        // @see https://regex101.com/r/tlvfTB/1
        if (!\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
            return \false;
        }
        $reflectionClass = new \ReflectionClass($className);
        if ($this->hasStaticAnnotation($methodName, $reflectionClass)) {
            return \true;
        }
        // probably magic method → we don't know
        if (!\method_exists($className, $methodName)) {
            return \false;
        }
        $methodReflection = $reflectionClass->getMethod($methodName);
        return $methodReflection->isStatic();
    }
    private function hasStaticAnnotation(string $methodName, \ReflectionClass $reflectionClass) : bool
    {
        return (bool) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match((string) $reflectionClass->getDocComment(), '#@method\\s*static\\s*(.*?)\\b' . $methodName . '\\b#');
    }
}
