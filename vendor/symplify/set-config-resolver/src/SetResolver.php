<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SetConfigResolver;

use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\Option\OptionName;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\OptionValueResolver;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->optionValueResolver = new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\OptionValueResolver();
        $this->setProvider = $setProvider;
    }
    public function detectFromInput(\_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        $setName = $this->optionValueResolver->getOptionValue($input, \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Console\Option\OptionName::SET);
        if ($setName === null) {
            return null;
        }
        return $this->detectFromName($setName);
    }
    public function detectFromName(string $setName) : \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
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
        throw new \_PhpScoperb75b35f52b74\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
