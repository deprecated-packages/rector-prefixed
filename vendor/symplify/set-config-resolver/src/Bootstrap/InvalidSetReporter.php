<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SetConfigResolver\Bootstrap;

use _PhpScopere8e811afab72\Nette\Utils\ObjectHelpers;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScopere8e811afab72\Symplify\SetConfigResolver\Exception\SetNotFoundException;
final class InvalidSetReporter
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct()
    {
        $symfonyStyleFactory = new \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory();
        $this->symfonyStyle = $symfonyStyleFactory->create();
    }
    public function report(\_PhpScopere8e811afab72\Symplify\SetConfigResolver\Exception\SetNotFoundException $setNotFoundException) : void
    {
        $message = $setNotFoundException->getMessage();
        $suggestedSet = \_PhpScopere8e811afab72\Nette\Utils\ObjectHelpers::getSuggestion($setNotFoundException->getAvailableSetNames(), $setNotFoundException->getSetName());
        if ($suggestedSet !== null) {
            $message .= \sprintf('. Did you mean "%s"?', $suggestedSet);
            $this->symfonyStyle->error($message);
        } elseif ($setNotFoundException->getAvailableSetNames() !== []) {
            $this->symfonyStyle->error($message);
            $this->symfonyStyle->note('Pick one of:');
            $this->symfonyStyle->listing($setNotFoundException->getAvailableSetNames());
        }
    }
}
