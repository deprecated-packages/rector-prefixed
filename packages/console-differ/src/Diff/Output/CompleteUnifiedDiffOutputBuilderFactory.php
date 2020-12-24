<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\ConsoleDiffer\Diff\Output;

use _PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
/**
 * Creates @see UnifiedDiffOutputBuilder with "$contextLines = 1000;"
 */
final class CompleteUnifiedDiffOutputBuilderFactory
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct()
    {
        $this->privatesAccessor = new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesAccessor();
    }
    /**
     * @api
     */
    public function create() : \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder
    {
        $unifiedDiffOutputBuilder = new \_PhpScoperb75b35f52b74\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder('');
        $this->privatesAccessor->setPrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 1000);
        return $unifiedDiffOutputBuilder;
    }
}
