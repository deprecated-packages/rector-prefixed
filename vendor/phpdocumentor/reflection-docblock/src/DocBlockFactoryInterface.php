<?php

namespace _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection;

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
    public function create($docblock, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context $context = null, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Location $location = null);
}
