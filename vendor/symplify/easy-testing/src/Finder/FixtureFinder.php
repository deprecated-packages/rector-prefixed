<?php

declare (strict_types=1);
namespace RectorPrefix20210210\Symplify\EasyTesting\Finder;

use RectorPrefix20210210\Symfony\Component\Finder\Finder;
use RectorPrefix20210210\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\RectorPrefix20210210\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \RectorPrefix20210210\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
