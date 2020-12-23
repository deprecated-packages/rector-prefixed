<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Command\Symfony;

use _PhpScoper0a2ac50786fa\PHPStan\Command\Output;
use _PhpScoper0a2ac50786fa\PHPStan\Command\OutputStyle;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface;
/**
 * @internal
 */
class SymfonyOutput implements \_PhpScoper0a2ac50786fa\PHPStan\Command\Output
{
    /** @var \Symfony\Component\Console\Output\OutputInterface */
    private $symfonyOutput;
    /** @var OutputStyle */
    private $style;
    public function __construct(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface $symfonyOutput, \_PhpScoper0a2ac50786fa\PHPStan\Command\OutputStyle $style)
    {
        $this->symfonyOutput = $symfonyOutput;
        $this->style = $style;
    }
    public function writeFormatted(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeLineFormatted(string $message) : void
    {
        $this->symfonyOutput->writeln($message, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeRaw(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    public function getStyle() : \_PhpScoper0a2ac50786fa\PHPStan\Command\OutputStyle
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
