<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection;

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
    public function create($docblock, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context $context = null, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Location $location = null);
}
