<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Configuration\Collector;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];
    public function addVariableNameAndType(string $name, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : void
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
