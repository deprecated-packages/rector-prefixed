<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command\Symfony;

use _PhpScoperb75b35f52b74\PHPStan\Command\Output;
use _PhpScoperb75b35f52b74\PHPStan\Command\OutputStyle;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface;
/**
 * @internal
 */
class SymfonyOutput implements \_PhpScoperb75b35f52b74\PHPStan\Command\Output
{
    /** @var \Symfony\Component\Console\Output\OutputInterface */
    private $symfonyOutput;
    /** @var OutputStyle */
    private $style;
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface $symfonyOutput, \_PhpScoperb75b35f52b74\PHPStan\Command\OutputStyle $style)
    {
        $this->symfonyOutput = $symfonyOutput;
        $this->style = $style;
    }
    public function writeFormatted(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeLineFormatted(string $message) : void
    {
        $this->symfonyOutput->writeln($message, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_NORMAL);
    }
    public function writeRaw(string $message) : void
    {
        $this->symfonyOutput->write($message, \false, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);
    }
    public function getStyle() : \_PhpScoperb75b35f52b74\PHPStan\Command\OutputStyle
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
