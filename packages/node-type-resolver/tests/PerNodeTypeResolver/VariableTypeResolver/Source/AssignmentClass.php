<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

final class AssignmentClass
{
    /**
     * @var FirstType
     */
    private $property;
    public function getValue() : \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\SecondType
    {
        $variable = new \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType();
        $assignedVariable = $variable;
    }
}
$someClass = new \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\NewClass();
