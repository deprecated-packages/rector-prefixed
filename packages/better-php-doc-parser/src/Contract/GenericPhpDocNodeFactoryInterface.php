<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract;

interface GenericPhpDocNodeFactoryInterface extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
{
    /**
     * @return string[]
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array;
}
