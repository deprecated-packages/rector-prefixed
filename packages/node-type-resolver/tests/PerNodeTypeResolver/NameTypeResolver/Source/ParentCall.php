<?php

namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
