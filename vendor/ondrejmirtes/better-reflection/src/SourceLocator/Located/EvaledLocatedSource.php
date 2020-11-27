<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located;

class EvaledLocatedSource extends \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Located\LocatedSource
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
