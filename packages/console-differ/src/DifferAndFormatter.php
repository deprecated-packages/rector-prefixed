<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ConsoleDiffer;

use _PhpScopere8e811afab72\SebastianBergmann\Diff\Differ;
use _PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter;
/**
 * @deprecated Move to symplify
 */
final class DifferAndFormatter
{
    /**
     * @var Differ
     */
    private $differ;
    /**
     * @var ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    public function __construct(\_PhpScopere8e811afab72\Symplify\ConsoleColorDiff\Console\Formatter\ColorConsoleDiffFormatter $colorConsoleDiffFormatter, \_PhpScopere8e811afab72\SebastianBergmann\Diff\Differ $differ)
    {
        $this->differ = $differ;
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
    }
    public function diff(string $old, string $new) : string
    {
        if ($old === $new) {
            return '';
        }
        return $this->differ->diff($old, $new);
    }
    public function diffAndFormat(string $old, string $new) : string
    {
        if ($old === $new) {
            return '';
        }
        $diff = $this->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }
}
