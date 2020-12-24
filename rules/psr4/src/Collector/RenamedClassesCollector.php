<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PSR4\Collector;

use _PhpScoper0a6b37af0871\Rector\Core\Configuration\RenamedClassesDataCollector;
final class RenamedClassesCollector
{
    /**
     * @var array<string, string>
     */
    private $oldToNewClass = [];
    /**
     * @var RenamedClassesDataCollector
     */
    private $renamedClassesDataCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\RenamedClassesDataCollector $renamedClassesDataCollector)
    {
        $this->renamedClassesDataCollector = $renamedClassesDataCollector;
    }
    public function addClassRename(string $oldClass, string $newClass) : void
    {
        $this->oldToNewClass[$oldClass] = $newClass;
    }
    /**
     * @return array<string, string>
     */
    public function getOldToNewClasses() : array
    {
        return \array_merge($this->oldToNewClass, $this->renamedClassesDataCollector->getOldToNewClasses());
    }
}
