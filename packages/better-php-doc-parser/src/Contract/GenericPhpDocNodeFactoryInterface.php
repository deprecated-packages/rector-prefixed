<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

interface GenericPhpDocNodeFactoryInterface extends \Rector\BetterPhpDocParser\Contract\PhpDocNodeFactoryInterface
{
    /**
     * @return string[]
     */
    public function getTagValueNodeClassesToAnnotationClasses() : array;
}
