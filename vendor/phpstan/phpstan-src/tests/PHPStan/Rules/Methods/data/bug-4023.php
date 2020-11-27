<?php

namespace _PhpScoper006a73f0e455\Bug4023;

interface A
{
    /**
     * @template T of object
     *
     * @param mixed[]|T       $data
     *
     * @return T
     */
    public function x($data) : object;
}
final class B implements \_PhpScoper006a73f0e455\Bug4023\A
{
    /**
     * @template T of object
     *
     * @param mixed[]|T       $data
     *
     * @return T
     */
    public function x($data) : object
    {
        throw new \Exception();
    }
}
