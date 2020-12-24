<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Configuration;

final class RenamedClassesDataCollector
{
    /**
     * @var array<string, string>
     */
    private $oldToNewClasses = [];
    /**
     * @param array<string, string> $oldToNewClasses
     */
    public function setOldToNewClasses(array $oldToNewClasses) : void
    {
        $this->oldToNewClasses = $oldToNewClasses;
    }
    /**
     * @return array<string, string>
     */
    public function getOldToNewClasses() : array
    {
        return $this->oldToNewClasses;
    }
}
