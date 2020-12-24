<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer;

use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Exception\ConflictingPriorityException;
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
    private function ensurePriorityIsUnique(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PriorityAwareTypeInfererInterface $priorityAwareTypeInferer) : void
    {
        if (!isset($this->sortedTypeInferers[$priorityAwareTypeInferer->getPriority()])) {
            return;
        }
        $alreadySetPropertyTypeInferer = $this->sortedTypeInferers[$priorityAwareTypeInferer->getPriority()];
        throw new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Exception\ConflictingPriorityException($priorityAwareTypeInferer, $alreadySetPropertyTypeInferer);
    }
}
