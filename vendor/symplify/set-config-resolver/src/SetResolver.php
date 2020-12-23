<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Console\Option\OptionName;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Console\OptionValueResolver;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class SetResolver
{
    /**
     * @var OptionValueResolver
     */
    private $optionValueResolver;
    /**
     * @var SetProviderInterface
     */
    private $setProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->optionValueResolver = new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Console\OptionValueResolver();
        $this->setProvider = $setProvider;
    }
    public function detectFromInput(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
    {
        $setName = $this->optionValueResolver->getOptionValue($input, \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Console\Option\OptionName::SET);
        if ($setName === null) {
            return null;
        }
        return $this->detectFromName($setName);
    }
    public function detectFromName(string $setName) : \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo
    {
        $set = $this->setProvider->provideByName($setName);
        if ($set === null) {
            $this->reportSetNotFound($setName);
        }
        return $set->getSetFileInfo();
    }
    private function reportSetNotFound(string $setName) : void
    {
        $message = \sprintf('Set "%s" was not found', $setName);
        throw new \_PhpScoper0a2ac50786fa\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
