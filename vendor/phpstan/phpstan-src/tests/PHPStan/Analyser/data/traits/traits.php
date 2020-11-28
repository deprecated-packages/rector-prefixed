<?php

namespace _PhpScoperabd03f0baf05\TraitPhpDocs;

class Foo extends \_PhpScoperabd03f0baf05\TraitPhpDocs\Bar
{
    use \TraitPhpDocsTwo\FooTrait, \TraitPhpDocsThree\BarTrait {
        \TraitPhpDocsTwo\FooTrait::methodInMoreTraits insteadof \TraitPhpDocsThree\BarTrait;
        \TraitPhpDocsThree\BarTrait::anotherMethodInMoreTraits insteadof \TraitPhpDocsTwo\FooTrait;
        \TraitPhpDocsTwo\FooTrait::yetAnotherMethodInMoreTraits insteadof \TraitPhpDocsThree\BarTrait;
        \TraitPhpDocsThree\BarTrait::yetAnotherMethodInMoreTraits as aliasedYetAnotherMethodInMoreTraits;
        \TraitPhpDocsThree\BarTrait::yetYetAnotherMethodInMoreTraits insteadof \TraitPhpDocsTwo\FooTrait;
        \TraitPhpDocsTwo\FooTrait::yetYetAnotherMethodInMoreTraits as aliasedYetYetAnotherMethodInMoreTraits;
    }
    /** @var PropertyTypeFromClass */
    private $conflictingProperty;
    /** @var AmbiguousPropertyType */
    private $bogusProperty;
    /** @var BogusPropertyType */
    private $anotherBogusProperty;
    public function doFoo()
    {
        die;
    }
    /**
     * @return MethodTypeFromClass
     */
    public function conflictingMethod()
    {
    }
    /**
     * @return AmbiguousMethodType
     */
    public function bogusMethod()
    {
    }
    /**
     * @return BogusMethodType
     */
    public function anotherBogusMethod()
    {
    }
}
