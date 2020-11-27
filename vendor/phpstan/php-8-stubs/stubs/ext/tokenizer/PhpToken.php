<?php

namespace _PhpScoperbd5d0c5f7638;

class PhpToken implements \Stringable
{
    /** @return static[] */
    public static function tokenize(string $code, int $flags = 0) : array
    {
    }
    public final function __construct(int $id, string $text, int $line = -1, int $pos = -1)
    {
    }
    /** @param int|string|array $kind */
    public function is($kind) : bool
    {
    }
    public function isIgnorable() : bool
    {
    }
    public function getTokenName() : ?string
    {
    }
    public function __toString() : string
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\PhpToken', 'PhpToken', \false);
