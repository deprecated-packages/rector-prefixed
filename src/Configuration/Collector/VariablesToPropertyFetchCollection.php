<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Configuration\Collector;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];
    public function addVariableNameAndType(string $name, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : void
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
