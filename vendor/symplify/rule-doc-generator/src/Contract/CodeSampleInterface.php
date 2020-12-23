<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\Contract;

interface CodeSampleInterface
{
    public function getGoodCode() : string;
    public function getBadCode() : string;
}
