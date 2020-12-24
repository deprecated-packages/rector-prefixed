<?php

namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
