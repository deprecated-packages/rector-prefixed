<?php

namespace _PhpScoperabd03f0baf05\AnonymousTraitClass;

trait TraitWithTypeSpecification
{
    /** @var string */
    private $string;
    public function doFoo() : void
    {
        if (!$this instanceof \_PhpScoperabd03f0baf05\AnonymousTraitClass\FooInterface) {
            return;
        }
        $this->string = 'foo';
        $this->nonexistent = 'bar';
    }
}
