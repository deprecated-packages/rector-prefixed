<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Configuration\Collector;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];
    public function addVariableNameAndType(string $name, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : void
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
