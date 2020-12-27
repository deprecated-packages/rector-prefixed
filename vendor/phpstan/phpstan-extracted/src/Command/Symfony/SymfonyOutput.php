<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command\Symfony;

use RectorPrefix20201227\PHPStan\Command\Output;
use RectorPrefix20201227\PHPStan\Command\OutputStyle;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface;
/**
 * @internal
 */
class SymfonyOutput implements \RectorPrefix20201227\PHPStan\Command\Output
{
    /** @var \Symfony\Component\Console\Output\OutputInterface */
    private $symfonyOutput;
    /** @var OutputStyle */
    private $style;
    public function __construct(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface $symfonyOutput, \RectorPrefix20201227\PHPStan\Command\OutputStyle $style)
    {
        $this->symfonyOutput = $symfonyOutput;
        $this->style = $style;
    }
    public function writeFormatted(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeLineFormatted(string $message) : void
    {
        $this->symfonyOutput->writeln($message, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeRaw(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    public function getStyle() : \RectorPrefix20201227\PHPStan\Command\OutputStyle
    {
        return $this->style;
    }
    public function isVerbose() : bool
    {
        return $this->symfonyOutput->isVerbose();
    }
    public function isDebug() : bool
    {
        return $this->symfonyOutput->isDebug();
    }
}
