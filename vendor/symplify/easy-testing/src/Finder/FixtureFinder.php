<?php

declare (strict_types=1);
namespace RectorPrefix20210128\Symplify\EasyTesting\Finder;

use RectorPrefix20210128\Symfony\Component\Finder\Finder;
use RectorPrefix20210128\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\RectorPrefix20210128\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \RectorPrefix20210128\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
