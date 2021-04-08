<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\ConsoleColorDiff\Console\Output;

use RectorPrefix20210408\SebastianBergmann\Diff\Differ;
use RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210408\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
final class ConsoleDiffer
{
    /**
     * @var Differ
     */
    private $differ;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    public function __construct(\RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \RectorPrefix20210408\SebastianBergmann\Diff\Differ $differ, \RectorPrefix20210408\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter $colorConsoleDiffFormatter)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->differ = $differ;
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
    }
    public function diff(string $old, string $new) : string
    {
        $diff = $this->differ->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }
    public function diffAndPrint(string $old, string $new) : void
    {
        $formattedDiff = $this->diff($old, $new);
        $this->symfonyStyle->writeln($formattedDiff);
    }
}
