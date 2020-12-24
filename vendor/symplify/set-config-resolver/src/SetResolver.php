<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Console\Option\OptionName;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Console\OptionValueResolver;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->optionValueResolver = new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Console\OptionValueResolver();
        $this->setProvider = $setProvider;
    }
    public function detectFromInput(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Input\InputInterface $input) : ?\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
    {
        $setName = $this->optionValueResolver->getOptionValue($input, \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Console\Option\OptionName::SET);
        if ($setName === null) {
            return null;
        }
        return $this->detectFromName($setName);
    }
    public function detectFromName(string $setName) : \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
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
        throw new \_PhpScoper2a4e7ab1ecbc\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
