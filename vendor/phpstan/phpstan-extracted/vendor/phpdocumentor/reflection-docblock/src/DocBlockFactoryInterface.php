<?php

namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection;

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
    public function create($docblock, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context $context = null, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Location $location = null);
}
