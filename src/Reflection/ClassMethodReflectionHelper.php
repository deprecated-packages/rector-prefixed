<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Reflection;

use _PhpScopere8e811afab72\Nette\Utils\Reflection;
use _PhpScopere8e811afab72\Rector\Core\PhpDoc\PhpDocTagsFinder;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Reflection\ClassMethodReflectionFactory $classMethodReflectionFactory, \_PhpScopere8e811afab72\Rector\Core\PhpDoc\PhpDocTagsFinder $phpDocTagsFinder)
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
            $className = \_PhpScopere8e811afab72\Nette\Utils\Reflection::expandClassName($returnTag, $reflectedMethod->getDeclaringClass());
            $classes[] = $className;
        }
        return $classes;
    }
}
