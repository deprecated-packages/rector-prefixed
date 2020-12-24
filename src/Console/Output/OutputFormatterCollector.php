<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Console\Output;

use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\Console\Output\MissingOutputFormatterException;
final class OutputFormatterCollector
{
    /**
     * @var OutputFormatterInterface[]
     */
    private $outputFormatters = [];
    /**
     * @param OutputFormatterInterface[] $outputFormatters
     */
    public function __construct(array $outputFormatters)
    {
        foreach ($outputFormatters as $outputFormatter) {
            $this->outputFormatters[$outputFormatter->getName()] = $outputFormatter;
        }
    }
    public function getByName(string $name) : \_PhpScoper0a6b37af0871\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface
    {
        $this->ensureOutputFormatExists($name);
        return $this->outputFormatters[$name];
    }
    /**
     * @return int[]|string[]
     */
    public function getNames() : array
    {
        return \array_keys($this->outputFormatters);
    }
    private function ensureOutputFormatExists(string $name) : void
    {
        if (isset($this->outputFormatters[$name])) {
            return;
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\Console\Output\MissingOutputFormatterException(\sprintf('Output formatter "%s" was not found. Pick one of "%s".', $name, \implode('", "', $this->getNames())));
    }
}
