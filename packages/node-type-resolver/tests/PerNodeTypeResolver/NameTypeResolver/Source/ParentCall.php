<?php

namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
