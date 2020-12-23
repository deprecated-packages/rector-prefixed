<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Collector;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];
    public function addVariableNameAndType(string $name, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : void
    {
        $this->variableNameAndType[$name] = $type;
    }
    /**
     * @return Type[]
     */
    public function getVariableNamesAndTypes() : array
    {
        return $this->variableNameAndType;
    }
}
