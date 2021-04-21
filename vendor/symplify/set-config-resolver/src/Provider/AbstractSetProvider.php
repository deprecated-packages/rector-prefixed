<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\SetConfigResolver\Provider;

use RectorPrefix20210421\Nette\Utils\Strings;
use RectorPrefix20210421\Symplify\SetConfigResolver\Contract\SetProviderInterface;
use RectorPrefix20210421\Symplify\SetConfigResolver\Exception\SetNotFoundException;
use RectorPrefix20210421\Symplify\SetConfigResolver\ValueObject\Set;
use RectorPrefix20210421\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
abstract class AbstractSetProvider implements \RectorPrefix20210421\Symplify\SetConfigResolver\Contract\SetProviderInterface
{
    /**
     * @return string[]
     */
    public function provideSetNames() : array
    {
        $setNames = [];
        $sets = $this->provide();
        foreach ($sets as $set) {
            $setNames[] = $set->getName();
        }
        return $setNames;
    }
    /**
     * @return \Symplify\SetConfigResolver\ValueObject\Set|null
     */
    public function provideByName(string $desiredSetName)
    {
        // 1. name-based approach
        $sets = $this->provide();
        foreach ($sets as $set) {
            if ($set->getName() !== $desiredSetName) {
                continue;
            }
            return $set;
        }
        // 2. path-based approach
        try {
            $sets = $this->provide();
            foreach ($sets as $set) {
                // possible bug for PHAR files, see https://bugs.php.net/bug.php?id=52769
                // this is very tricky to handle, see https://stackoverflow.com/questions/27838025/how-to-get-a-phar-file-real-directory-within-the-phar-file-code
                $setUniqueId = $this->resolveSetUniquePathId($set->getSetPathname());
                $desiredSetUniqueId = $this->resolveSetUniquePathId($desiredSetName);
                if ($setUniqueId !== $desiredSetUniqueId) {
                    continue;
                }
                return $set;
            }
        } catch (\RectorPrefix20210421\Symplify\SymplifyKernel\Exception\ShouldNotHappenException $shouldNotHappenException) {
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \RectorPrefix20210421\Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function resolveSetUniquePathId(string $setPath) : string
    {
        $setPath = \RectorPrefix20210421\Nette\Utils\Strings::after($setPath, \DIRECTORY_SEPARATOR, -2);
        if ($setPath === null) {
            throw new \RectorPrefix20210421\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $setPath;
    }
}
