<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Reflection;

use _PhpScoperb75b35f52b74\Nette\Utils\Reflection;
use _PhpScoperb75b35f52b74\Rector\Core\PhpDoc\PhpDocTagsFinder;
final class ClassMethodReflectionHelper
{
    /**
     * @var ClassMethodReflectionFactory
     */
    private $classMethodReflectionFactory;
    /**
     * @var PhpDocTagsFinder
     */
    private $phpDocTagsFinder;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Reflection\ClassMethodReflectionFactory $classMethodReflectionFactory, \_PhpScoperb75b35f52b74\Rector\Core\PhpDoc\PhpDocTagsFinder $phpDocTagsFinder)
    {
        $this->classMethodReflectionFactory = $classMethodReflectionFactory;
        $this->phpDocTagsFinder = $phpDocTagsFinder;
    }
    /**
     * @return array<class-string>
     */
    public function extractTagsFromMethodDocBlock(string $class, string $method) : array
    {
        $reflectedMethod = $this->classMethodReflectionFactory->createReflectionMethodIfExists($class, $method);
        if ($reflectedMethod === null) {
            return [];
        }
        $docComment = $reflectedMethod->getDocComment();
        if (!\is_string($docComment)) {
            return [];
        }
        $throwsTypes = $this->phpDocTagsFinder->extractTrowsTypesFromDocBlock($docComment);
        $classes = [];
        foreach ($throwsTypes as $returnTag) {
            /** @var class-string $className */
            $className = \_PhpScoperb75b35f52b74\Nette\Utils\Reflection::expandClassName($returnTag, $reflectedMethod->getDeclaringClass());
            $classes[] = $className;
        }
        return $classes;
    }
}
