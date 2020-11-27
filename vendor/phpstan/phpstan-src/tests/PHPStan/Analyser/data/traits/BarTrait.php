<?php

namespace _PhpScoper88fe6e0ad041\TraitPhpDocsThree;

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
