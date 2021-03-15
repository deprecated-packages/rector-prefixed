<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Finder;

use RectorPrefix20210315\Nette\Loaders\RobotLoader;
use ReflectionClass;
use Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath;
use RectorPrefix20210315\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassByTypeFinder
{
    /**
     * @param string[] $directories
     * @return RuleClassWithFilePath[]
     */
    public function findByType(string $workingDirectory, array $directories, string $type) : array
    {
        $robotLoader = new \RectorPrefix20210315\Nette\Loaders\RobotLoader();
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/robot_loader_temp');
        $robotLoader->addDirectory(...$directories);
        $robotLoader->ignoreDirs[] = '*tests*';
        $robotLoader->ignoreDirs[] = '*Fixture*';
        $robotLoader->ignoreDirs[] = '*templates*';
        $robotLoader->rebuild();
        $desiredClasses = [];
        foreach ($robotLoader->getIndexedClasses() as $class => $file) {
            if (!\is_a($class, $type, \true)) {
                continue;
            }
            // skip abstract classes
            $reflectionClass = new \ReflectionClass($class);
            if ($reflectionClass->isAbstract()) {
                continue;
            }
            $fileInfo = new \RectorPrefix20210315\Symplify\SmartFileSystem\SmartFileInfo($file);
            $relativeFilePath = $fileInfo->getRelativeFilePathFromDirectory($workingDirectory);
            $desiredClasses[] = new \Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath($class, $relativeFilePath);
        }
        \usort($desiredClasses, function (\Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath $left, \Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath $right) : int {
            return $left->getClass() <=> $right->getClass();
        });
        return $desiredClasses;
    }
}
