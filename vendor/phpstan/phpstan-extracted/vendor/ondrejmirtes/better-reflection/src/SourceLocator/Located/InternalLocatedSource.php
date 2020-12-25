<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located;

class InternalLocatedSource extends \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
{
    /** @var string */
    private $extensionName;
    /**
     * {@inheritDoc}
     */
    public function __construct(string $source, string $extensionName, ?string $fileName = null)
    {
        parent::__construct($source, $fileName);
        $this->extensionName = $extensionName;
    }
    public function isInternal() : bool
    {
        return \true;
    }
    public function getExtensionName() : ?string
    {
        return $this->extensionName;
    }
}
