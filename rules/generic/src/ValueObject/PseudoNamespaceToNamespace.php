<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject;

final class PseudoNamespaceToNamespace
{
    /**
     * @var string
     */
    private $namespacePrefix;
    /**
     * @var string[]
     */
    private $excludedClasses = [];
    /**
     * @param string[] $excludedClasses
     */
    public function __construct(string $namespacePrefix, array $excludedClasses = [])
    {
        $this->namespacePrefix = $namespacePrefix;
        $this->excludedClasses = $excludedClasses;
    }
    public function getNamespacePrefix() : string
    {
        return $this->namespacePrefix;
    }
    /**
     * @return string[]
     */
    public function getExcludedClasses() : array
    {
        return $this->excludedClasses;
    }
}
