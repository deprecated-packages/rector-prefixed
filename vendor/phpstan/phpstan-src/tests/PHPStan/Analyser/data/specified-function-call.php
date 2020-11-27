<?php

namespace _PhpScoper88fe6e0ad041\SpecifiedFunctionCall;

class IsFileChecks
{
    public function isFile(string $autoloadFile)
    {
        if (\is_file($autoloadFile) === \true) {
            'first';
            if (\is_file($autoloadFile) === \true) {
                'second';
            }
        }
    }
    public function isFileAnother(string $autoloadFile, string $other)
    {
        if (\is_file($autoloadFile) === \true) {
            'third';
            $autoloadFile = $other;
            'fourth';
            if (\is_file($autoloadFile) === \true) {
                'fifth';
            }
        }
    }
}
