<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

final class AssignmentClass
{
    /**
     * @var FirstType
     */
    private $property;
    public function getValue() : \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\SecondType
    {
        $variable = new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType();
        $assignedVariable = $variable;
    }
}
$someClass = new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\NewClass();
