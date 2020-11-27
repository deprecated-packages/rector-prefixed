<?php

namespace _PhpScopera143bcca66cb\AnonymousTraitClass;

trait TraitWithTypeSpecification
{
    /** @var string */
    private $string;
    public function doFoo() : void
    {
        if (!$this instanceof \_PhpScopera143bcca66cb\AnonymousTraitClass\FooInterface) {
            return;
        }
        $this->string = 'foo';
        $this->nonexistent = 'bar';
    }
}
