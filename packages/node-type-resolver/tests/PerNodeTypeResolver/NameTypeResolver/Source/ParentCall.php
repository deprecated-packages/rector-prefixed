<?php

namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
