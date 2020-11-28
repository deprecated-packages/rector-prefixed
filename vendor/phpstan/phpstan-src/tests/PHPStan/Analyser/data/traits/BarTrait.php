<?php

namespace _PhpScoperabd03f0baf05\TraitPhpDocsThree;

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
