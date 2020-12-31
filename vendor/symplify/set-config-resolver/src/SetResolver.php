<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Symplify\SetConfigResolver;

use RectorPrefix20201231\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20201231\Symplify\SetConfigResolver\Console\Option\OptionName;
use RectorPrefix20201231\Symplify\SetConfigResolver\Console\OptionValueResolver;
use RectorPrefix20201231\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use RectorPrefix20201231\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\RectorPrefix20201231\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->optionValueResolver = new \RectorPrefix20201231\Symplify\SetConfigResolver\Console\OptionValueResolver();
        $this->setProvider = $setProvider;
    }
    public function detectFromInput(\RectorPrefix20201231\Symfony\Component\Console\Input\InputInterface $input) : ?\RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo
    {
        $setName = $this->optionValueResolver->getOptionValue($input, \RectorPrefix20201231\Symplify\SetConfigResolver\Console\Option\OptionName::SET);
        if ($setName === null) {
            return null;
        }
        return $this->detectFromName($setName);
    }
    public function detectFromName(string $setName) : \RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo
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
        throw new \RectorPrefix20201231\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
