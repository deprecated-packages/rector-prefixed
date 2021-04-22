<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Symplify\SetConfigResolver;

use RectorPrefix20210422\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use RectorPrefix20210422\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use RectorPrefix20210422\Symplify\SetConfigResolver\ValueObject\Set;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo;
final class SetResolver
{
    /**
     * @var SetProviderInterface
     */
    private $setProvider;
    public function __construct(\RectorPrefix20210422\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setProvider = $setProvider;
    }
    public function detectFromName(string $setName) : \RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo
    {
        $set = $this->setProvider->provideByName($setName);
        if (!$set instanceof \RectorPrefix20210422\Symplify\SetConfigResolver\ValueObject\Set) {
            $this->reportSetNotFound($setName);
        }
        return $set->getSetFileInfo();
    }
    /**
     * @return void
     */
    private function reportSetNotFound(string $setName)
    {
        $message = \sprintf('Set "%s" was not found', $setName);
        throw new \RectorPrefix20210422\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
