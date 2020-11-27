<?php

namespace _PhpScoper006a73f0e455\phpDocumentor\Reflection;

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
    public function create($docblock, \_PhpScoper006a73f0e455\phpDocumentor\Reflection\Types\Context $context = null, \_PhpScoper006a73f0e455\phpDocumentor\Reflection\Location $location = null);
}
