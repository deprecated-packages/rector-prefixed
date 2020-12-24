<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Collector;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];
    public function addVariableNameAndType(string $name, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : void
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
