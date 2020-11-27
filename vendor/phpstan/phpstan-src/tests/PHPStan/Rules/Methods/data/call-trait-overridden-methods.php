<?php

namespace _PhpScoper88fe6e0ad041\CallTraitOverriddenMethods;

trait TraitA
{
    function sameName()
    {
    }
}
trait TraitB
{
    use TraitA {
        sameName as someOtherName;
    }
    function sameName()
    {
        $this->someOtherName();
    }
}
trait TraitC
{
    use TraitB {
        sameName as YetAnotherName;
    }
    function sameName()
    {
        $this->YetAnotherName();
    }
}
class SomeClass
{
    use TraitC {
        sameName as wowSoManyNames;
    }
    function sameName()
    {
        $this->wowSoManyNames();
    }
}
