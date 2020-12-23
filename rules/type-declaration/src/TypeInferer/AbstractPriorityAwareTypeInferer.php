<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer;

use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Exception\ConflictingPriorityException;
abstract class AbstractPriorityAwareTypeInferer
{
    /**
     * @var PriorityAwareTypeInfererInterface[]
     */
    private $sortedTypeInferers = [];
    /**
     * @param PriorityAwareTypeInfererInterface[] $priorityAwareTypeInferers
     * @return PriorityAwareTypeInfererInterface[]
     */
    protected function sortTypeInferersByPriority(array $priorityAwareTypeInferers) : array
    {
        $this->sortedTypeInferers = [];
        foreach ($priorityAwareTypeInferers as $propertyTypeInferer) {
            $this->ensurePriorityIsUnique($propertyTypeInferer);
            $this->sortedTypeInferers[$propertyTypeInferer->getPriority()] = $propertyTypeInferer;
        }
        \krsort($this->sortedTypeInferers);
        return $this->sortedTypeInferers;
    }
    private function ensurePriorityIsUnique(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface $priorityAwareTypeInferer) : void
    {
        if (!isset($this->sortedTypeInferers[$priorityAwareTypeInferer->getPriority()])) {
            return;
        }
        $alreadySetPropertyTypeInferer = $this->sortedTypeInferers[$priorityAwareTypeInferer->getPriority()];
        throw new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Exception\ConflictingPriorityException($priorityAwareTypeInferer, $alreadySetPropertyTypeInferer);
    }
}
