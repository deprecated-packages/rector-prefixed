<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Provider;

use Rector\Core\Util\StaticRectorStrings;
use RectorPrefix20201228\Symfony\Component\Finder\Finder;
final class PackageNamesProvider
{
    /**
     * @return array<int, string>
     */
    public function provide() : array
    {
        $finder = new \RectorPrefix20201228\Symfony\Component\Finder\Finder();
        $directoriesList = $finder->directories()->depth(0)->in(__DIR__ . '/../../../../rules/')->getIterator();
        $names = [];
        foreach ($directoriesList as $directory) {
            $names[] = \Rector\Core\Util\StaticRectorStrings::dashesToCamelCase($directory->getFilename());
        }
        return $names;
    }
}
