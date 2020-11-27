<?php

namespace _PhpScoperbd5d0c5f7638\Bug4023;

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
final class B implements \_PhpScoperbd5d0c5f7638\Bug4023\A
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
