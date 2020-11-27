<?php

declare (strict_types=1);
namespace PHPStan\Command\Symfony;

use PHPStan\Command\Output;
use PHPStan\Command\OutputStyle;
use _PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface;
/**
 * @internal
 */
class SymfonyOutput implements \PHPStan\Command\Output
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $symfonyOutput;
    /**
     * @var \PHPStan\Command\OutputStyle
     */
    private $style;
    public function __construct(\_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface $symfonyOutput, \PHPStan\Command\OutputStyle $style)
    {
        $this->symfonyOutput = $symfonyOutput;
        $this->style = $style;
    }
    public function writeFormatted(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeLineFormatted(string $message) : void
    {
        $this->symfonyOutput->writeln($message, \_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeRaw(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    public function getStyle() : \PHPStan\Command\OutputStyle
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
