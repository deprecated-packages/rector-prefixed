<?php

declare(strict_types=1);

namespace Rector\DependencyInjection\Collector;

use PHPStan\Type\Type;

final class VariablesToPropertyFetchCollection
{
    /**
     * @var Type[]
     */
    private $variableNameAndType = [];

    /**
     * @return void
     */
    public function addVariableNameAndType(string $name, Type $type)
    {
        $this->variableNameAndType[$name] = $type;
    }

    /**
     * @return Type[]
     */
    public function getVariableNamesAndTypes(): array
    {
        return $this->variableNameAndType;
    }
}
