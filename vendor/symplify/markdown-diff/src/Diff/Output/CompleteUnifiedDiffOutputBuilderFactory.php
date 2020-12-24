<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\MarkdownDiff\Diff\Output;

use _PhpScopere8e811afab72\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
/**
 * Creates @see UnifiedDiffOutputBuilder with "$contextLines = 1000;"
 */
final class CompleteUnifiedDiffOutputBuilderFactory
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor)
    {
        $this->privatesAccessor = $privatesAccessor;
    }
    /**
     * @api
     */
    public function create() : \_PhpScopere8e811afab72\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder
    {
        $unifiedDiffOutputBuilder = new \_PhpScopere8e811afab72\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder('');
        $this->privatesAccessor->setPrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 10000);
        return $unifiedDiffOutputBuilder;
    }
}
