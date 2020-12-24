<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

final class NewClass
{
    /**
     * @var FirstType
     */
    private $property;
    public function getValue() : \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\SecondType
    {
        $variable = new \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType();
        $variable->test();
        $assignedVariable = $variable;
    }
}
