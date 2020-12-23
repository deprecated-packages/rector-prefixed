<?php

namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
