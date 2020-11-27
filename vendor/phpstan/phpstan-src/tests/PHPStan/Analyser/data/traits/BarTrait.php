<?php

namespace _PhpScoper006a73f0e455\TraitPhpDocsThree;

trait BarTrait
{
    use BazTrait;
    /**
     * @return DuplicateMethodType
     */
    public function methodInMoreTraits()
    {
    }
    /**
     * @return AnotherDuplicateMethodType
     */
    public function anotherMethodInMoreTraits()
    {
    }
    /**
     * @return YetAnotherDuplicateMethodType
     */
    public function yetAnotherMethodInMoreTraits()
    {
    }
    /**
     * @return YetYetAnotherDuplicateMethodType
     */
    public function yetYetAnotherMethodInMoreTraits()
    {
    }
}
