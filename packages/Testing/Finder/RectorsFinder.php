<?php

declare (strict_types=1);
namespace Rector\Testing\Finder;

use RectorPrefix20210317\Nette\Loaders\RobotLoader;
use RectorPrefix20210317\Nette\Utils\Strings;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\Error\ExceptionCorrector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\PostRector\Contract\Rector\PostRectorInterface;
use ReflectionClass;
final class RectorsFinder
{
    /**
     * @var string[]
     */
    private const RECTOR_PATHS = [__DIR__ . '/../../../rules', __DIR__ . '/../../../packages', __DIR__ . '/../../../src'];
    /**
     * @return array<class-string<RectorInterface>>
     */
    public function findCoreRectorClasses() : array
    {
        $allRectors = $this->findInDirectoriesAndCreate(self::RECTOR_PATHS);
        $rectorClasses = \array_map(function (\Rector\Core\Contract\Rector\RectorInterface $rector) : string {
            return \get_class($rector);
        }, $allRectors);
        // for consistency
        \sort($rectorClasses);
        return $rectorClasses;
    }
    /**
     * @param string[] $directories
     * @return RectorInterface[]
     */
    public function findInDirectoriesAndCreate(array $directories) : array
    {
        $foundClasses = $this->findClassesInDirectoriesByName($directories, '*Rector.php');
        $rectors = [];
        foreach ($foundClasses as $foundClass) {
            if ($this->shouldSkipClass($foundClass)) {
                continue;
            }
            $reflectionClass = new \ReflectionClass($foundClass);
            $rector = $reflectionClass->newInstanceWithoutConstructor();
            if (!$rector instanceof \Rector\Core\Contract\Rector\RectorInterface) {
                // lowercase letter bug in RobotLoader
                if (\RectorPrefix20210317\Nette\Utils\Strings::endsWith($foundClass, 'rector')) {
                    continue;
                }
                throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('"%s" found something that looks like Rector but does not implements "%s" interface.', __METHOD__, \Rector\Core\Contract\Rector\RectorInterface::class));
            }
            /** @var RectorInterface[] $rectors */
            $rectors[] = $rector;
        }
        return $this->sortRectorObjectsByShortClassName($rectors);
    }
    /**
     * @return PhpRectorInterface[]
     */
    public function findAndCreatePhpRectors() : array
    {
        $coreRectors = $this->findInDirectoriesAndCreate(self::RECTOR_PATHS);
        return \array_filter($coreRectors, function (\Rector\Core\Contract\Rector\RectorInterface $rector) : bool {
            return $rector instanceof \Rector\Core\Contract\Rector\PhpRectorInterface;
        });
    }
    /**
     * @param string[] $directories
     * @return array<class-string>
     */
    private function findClassesInDirectoriesByName(array $directories, string $name) : array
    {
        $robotLoader = new \RectorPrefix20210317\Nette\Loaders\RobotLoader();
        $robotLoader->addDirectory(...$directories);
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/_rector_finder');
        $robotLoader->acceptFiles = [$name];
        $robotLoader->refresh();
        $robotLoader->rebuild();
        return \array_keys($robotLoader->getIndexedClasses());
    }
    private function shouldSkipClass(string $class) : bool
    {
        // not relevant for documentation
        if (\is_a($class, \Rector\PostRector\Contract\Rector\PostRectorInterface::class, \true)) {
            return \true;
        }
        // special case, because robot loader is case insensitive
        if ($class === \Rector\Core\Error\ExceptionCorrector::class) {
            return \true;
        }
        // test fixture class
        if ($class === 'Rector\\ModeratePackage\\Rector\\MethodCall\\WhateverRector') {
            return \true;
        }
        if ($class === 'Utils\\Rector\\Rector\\MethodCall\\WhateverRector') {
            return \true;
        }
        if (!\class_exists($class)) {
            $message = \sprintf('Class "%s" was not found', $class);
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $reflectionClass = new \ReflectionClass($class);
        return $reflectionClass->isAbstract();
    }
    /**
     * @param RectorInterface[] $objects
     * @return RectorInterface[]
     */
    private function sortRectorObjectsByShortClassName(array $objects) : array
    {
        \usort($objects, function (object $firstObject, object $secondObject) : int {
            $firstRectorShortClass = \RectorPrefix20210317\Nette\Utils\Strings::after(\get_class($firstObject), '\\', -1);
            $secondRectorShortClass = \RectorPrefix20210317\Nette\Utils\Strings::after(\get_class($secondObject), '\\', -1);
            return $firstRectorShortClass <=> $secondRectorShortClass;
        });
        return $objects;
    }
}
