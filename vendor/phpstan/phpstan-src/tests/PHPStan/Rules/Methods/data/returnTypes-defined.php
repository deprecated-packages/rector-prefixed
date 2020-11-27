<?php

namespace _PhpScoper006a73f0e455\ReturnTypes;

class FooParent
{
    /**
     * @return static
     */
    public function returnStatic() : self
    {
        return $this;
    }
    /**
     * @return int
     */
    public function returnIntFromParent()
    {
        return 1;
    }
    /**
     * @return void
     */
    public function returnsVoid()
    {
    }
}
interface FooInterface
{
}
class OtherInterfaceImpl implements \_PhpScoper006a73f0e455\ReturnTypes\FooInterface
{
}
