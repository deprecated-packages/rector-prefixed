<?php

namespace _PhpScoperbd5d0c5f7638\AnonymousTraitClass;

trait TraitWithTypeSpecification
{
    /** @var string */
    private $string;
    public function doFoo() : void
    {
        if (!$this instanceof \_PhpScoperbd5d0c5f7638\AnonymousTraitClass\FooInterface) {
            return;
        }
        $this->string = 'foo';
        $this->nonexistent = 'bar';
    }
}
