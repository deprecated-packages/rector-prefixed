<?php

declare (strict_types=1);
namespace PHPStan\Command;

use _HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper\ProgressBar;
use _HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface;
use _HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface;
class ErrorsConsoleStyle extends \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Style\SymfonyStyle
{
    public const OPTION_NO_PROGRESS = 'no-progress';
    /** @var bool */
    private $showProgress;
    /** @var \Symfony\Component\Console\Helper\ProgressBar */
    private $progressBar;
    /** @var bool|null */
    private $isCiDetected = null;
    public function __construct(\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface $input, \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface $output)
    {
        parent::__construct($input, $output);
        $this->showProgress = $input->hasOption(self::OPTION_NO_PROGRESS) && !(bool) $input->getOption(self::OPTION_NO_PROGRESS);
    }
    private function isCiDetected() : bool
    {
        if ($this->isCiDetected === null) {
            $ciDetector = new \_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector();
            $this->isCiDetected = $ciDetector->isCiDetected();
        }
        return $this->isCiDetected;
    }
    /**
     * @param string[] $headers
     * @param string[][] $rows
     */
    public function table(array $headers, array $rows) : void
    {
        /** @var int $terminalWidth */
        $terminalWidth = (new \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Terminal())->getWidth() - 2;
        $maxHeaderWidth = \strlen($headers[0]);
        foreach ($rows as $row) {
            $length = \strlen($row[0]);
            if ($maxHeaderWidth !== 0 && $length <= $maxHeaderWidth) {
                continue;
            }
            $maxHeaderWidth = $length;
        }
        $wrap = static function ($rows) use($terminalWidth, $maxHeaderWidth) {
            return \array_map(static function ($row) use($terminalWidth, $maxHeaderWidth) {
                return \array_map(static function ($s) use($terminalWidth, $maxHeaderWidth) {
                    if ($terminalWidth > $maxHeaderWidth + 5) {
                        return \wordwrap($s, $terminalWidth - $maxHeaderWidth - 5, "\n", \true);
                    }
                    return $s;
                }, $row);
            }, $rows);
        };
        parent::table($headers, $wrap($rows));
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param int $max
     */
    public function createProgressBar($max = 0) : \_HumbugBox221ad6f1b81f\Symfony\Component\Console\Helper\ProgressBar
    {
        $this->progressBar = parent::createProgressBar($max);
        $this->progressBar->setOverwrite(!$this->isCiDetected());
        return $this->progressBar;
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param int $max
     */
    public function progressStart($max = 0) : void
    {
        if (!$this->showProgress) {
            return;
        }
        parent::progressStart($max);
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param int $step
     */
    public function progressAdvance($step = 1) : void
    {
        if (!$this->showProgress) {
            return;
        }
        if (!$this->isCiDetected() && $step > 0) {
            $stepTime = (\time() - $this->progressBar->getStartTime()) / $step;
            if ($stepTime > 0 && $stepTime < 1) {
                $this->progressBar->setRedrawFrequency((int) (1 / $stepTime));
            } else {
                $this->progressBar->setRedrawFrequency(1);
            }
        }
        parent::progressAdvance($step);
    }
    public function progressFinish() : void
    {
        if (!$this->showProgress) {
            return;
        }
        parent::progressFinish();
    }
}
