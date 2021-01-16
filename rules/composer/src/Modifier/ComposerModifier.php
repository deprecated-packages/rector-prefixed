<?php

declare (strict_types=1);
namespace Rector\Composer\Modifier;

use Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface;
use RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use RectorPrefix20210116\Webmozart\Assert\Assert;
/**
 * @see \Rector\Composer\Tests\Modifier\ComposerModifierTest
 */
final class ComposerModifier
{
    /**
     * @var string|null
     */
    private $filePath;
    /**
     * @var string
     */
    private $command = 'composer update';
    /**
     * @var ComposerModifierInterface[]
     */
    private $configuration = [];
    /**
     * @param ComposerModifierInterface[] $configuration
     */
    public function configure(array $configuration) : void
    {
        \RectorPrefix20210116\Webmozart\Assert\Assert::allIsInstanceOf($configuration, \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface::class);
        $this->configuration = \array_merge($this->configuration, $configuration);
    }
    /**
     * @param ComposerModifierInterface[] $configuration
     */
    public function reconfigure(array $configuration) : void
    {
        \RectorPrefix20210116\Webmozart\Assert\Assert::allIsInstanceOf($configuration, \Rector\Composer\Contract\ComposerModifier\ComposerModifierInterface::class);
        $this->configuration = $configuration;
    }
    public function setFilePath(string $filePath) : void
    {
        $this->filePath = $filePath;
    }
    public function getFilePath() : string
    {
        return $this->filePath ?: \getcwd() . '/composer.json';
    }
    public function setCommand(string $command) : void
    {
        $this->command = $command;
    }
    public function getCommand() : string
    {
        return $this->command;
    }
    public function modify(\RectorPrefix20210116\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : void
    {
        foreach ($this->configuration as $composerChanger) {
            $composerChanger->modify($composerJson);
        }
    }
}
