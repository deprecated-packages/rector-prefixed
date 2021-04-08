<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\SetConfigResolver;

use RectorPrefix20210408\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use RectorPrefix20210408\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use RectorPrefix20210408\Symplify\SetConfigResolver\ValueObject\Set;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class SetResolver
{
    /**
     * @var SetProviderInterface
     */
    private $setProvider;
    public function __construct(\RectorPrefix20210408\Symplify\SetConfigResolver\Contract\SetProviderInterface $setProvider)
    {
        $this->setProvider = $setProvider;
    }
    public function detectFromName(string $setName) : \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo
    {
        $set = $this->setProvider->provideByName($setName);
        if (!$set instanceof \RectorPrefix20210408\Symplify\SetConfigResolver\ValueObject\Set) {
            $this->reportSetNotFound($setName);
        }
        return $set->getSetFileInfo();
    }
    private function reportSetNotFound(string $setName) : void
    {
        $message = \sprintf('Set "%s" was not found', $setName);
        throw new \RectorPrefix20210408\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $setName, $this->setProvider->provideSetNames());
    }
}
