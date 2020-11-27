<?php

namespace _PhpScoper26e51eeacccf\AnonymousTraitClass;

trait TraitWithTypeSpecification
{
    /** @var string */
    private $string;
    public function doFoo() : void
    {
        if (!$this instanceof \_PhpScoper26e51eeacccf\AnonymousTraitClass\FooInterface) {
            return;
        }
        $this->string = 'foo';
        $this->nonexistent = 'bar';
    }
}
