<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located;

class EvaledLocatedSource extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
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
