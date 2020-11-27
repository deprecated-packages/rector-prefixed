<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located;

class InternalLocatedSource extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource
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
