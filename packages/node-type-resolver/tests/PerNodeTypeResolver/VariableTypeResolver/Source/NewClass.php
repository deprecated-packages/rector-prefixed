<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

final class NewClass
{
    /**
     * @var FirstType
     */
    private $property;
    public function getValue() : \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\SecondType
    {
        $variable = new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType();
        $variable->test();
        $assignedVariable = $variable;
    }
}
