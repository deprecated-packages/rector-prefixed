<?php

namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source;

use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild;
class ActionClass
{
    /**
     * @var SomeChild|null
     */
    private $someChildValueObject;
    public function someFunction()
    {
        $this->someChildValueObject = new \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild('value');
        $someChildValueObject = new \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild();
    }
}
