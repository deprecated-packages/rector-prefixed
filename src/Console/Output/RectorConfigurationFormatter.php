<?php

declare (strict_types=1);
namespace Rector\Core\Console\Output;

use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\NeonYaml\YamlPrinter;
use ReflectionClass;
use Symfony\Component\Console\Style\SymfonyStyle;
final class RectorConfigurationFormatter
{
    /**
     * @var YamlPrinter
     */
    private $yamlPrinter;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\Rector\Core\NeonYaml\YamlPrinter $yamlPrinter, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        $this->yamlPrinter = $yamlPrinter;
        $this->symfonyStyle = $symfonyStyle;
    }
    public function printRectorConfiguration(\Rector\Core\Contract\Rector\RectorInterface $rector) : void
    {
        $configuration = $this->resolveConfiguration($rector);
        if ($configuration === []) {
            return;
        }
        $configurationYamlContent = $this->yamlPrinter->printYamlToString($configuration);
        $lines = \explode(\PHP_EOL, $configurationYamlContent);
        $indentedContent = '      ' . \implode(\PHP_EOL . '      ', $lines);
        $this->symfonyStyle->writeln($indentedContent);
    }
    /**
     * Resolve configuration by convention
     * @return mixed[]
     */
    private function resolveConfiguration(\Rector\Core\Contract\Rector\RectorInterface $rector) : array
    {
        if (!$rector instanceof \Rector\Core\Contract\Rector\ConfigurableRectorInterface) {
            return [];
        }
        $reflectionClass = new \ReflectionClass($rector);
        $configuration = [];
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(\true);
            $configurationValue = $reflectionProperty->getValue($rector);
            // probably service → skip
            if (\is_object($configurationValue)) {
                continue;
            }
            $configuration[$reflectionProperty->getName()] = $configurationValue;
        }
        return $configuration;
    }
}
