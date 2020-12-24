<?php

namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source;

use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild;
class ActionClass
{
    /**
     * @var SomeChild|null
     */
    private $someChildValueObject;
    public function someFunction()
    {
        $this->someChildValueObject = new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild('value');
        $someChildValueObject = new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild();
    }
}
