<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ChangesReporting\ValueObject;

use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
final class RectorWithFileAndLineChange
{
    /**
     * @var string
     */
    private $realPath;
    /**
     * @var int
     */
    private $line;
    /**
     * @var RectorInterface
     */
    private $rector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface $rector, string $realPath, int $line)
    {
        $this->rector = $rector;
        $this->line = $line;
        $this->realPath = $realPath;
    }
    public function getRectorDefinitionsDescription() : string
    {
        $ruleDefinition = $this->rector->getRuleDefinition();
        return $ruleDefinition->getDescription();
    }
    public function getRectorClass() : string
    {
        return \get_class($this->rector);
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getRealPath() : string
    {
        return $this->realPath;
    }
}
