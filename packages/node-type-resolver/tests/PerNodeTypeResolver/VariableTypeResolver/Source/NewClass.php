<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

final class NewClass
{
    /**
     * @var FirstType
     */
    private $property;
    public function getValue() : \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\SecondType
    {
        $variable = new \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType();
        $variable->test();
        $assignedVariable = $variable;
    }
}
