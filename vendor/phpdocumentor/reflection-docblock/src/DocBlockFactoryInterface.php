<?php

namespace _PhpScopera143bcca66cb\phpDocumentor\Reflection;

interface DocBlockFactoryInterface
{
    /**
     * Factory method for easy instantiation.
     *
     * @param string[] $additionalTags
     *
     * @return DocBlockFactory
     */
    public static function createInstance(array $additionalTags = []);
    /**
     * @param string $docblock
     * @param Types\Context $context
     * @param Location $location
     *
     * @return DocBlock
     */
    public function create($docblock, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Types\Context $context = null, \_PhpScopera143bcca66cb\phpDocumentor\Reflection\Location $location = null);
}
