<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located;

class EvaledLocatedSource extends \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Located\LocatedSource
{
    /**
     * {@inheritDoc}
     */
    public function __construct(string $source)
    {
        parent::__construct($source, null);
    }
    public function isEvaled() : bool
    {
        return \true;
    }
}
