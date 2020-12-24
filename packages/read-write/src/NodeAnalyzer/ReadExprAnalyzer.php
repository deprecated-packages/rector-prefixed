<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\ReadWrite\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
final class ReadExprAnalyzer
{
    /**
     * @var ReadNodeAnalyzerInterface[]
     */
    private $readNodeAnalyzers = [];
    /**
     * @param ReadNodeAnalyzerInterface[] $readNodeAnalyzers
     */
    public function __construct(array $readNodeAnalyzers)
    {
        $this->readNodeAnalyzers = $readNodeAnalyzers;
    }
    /**
     * Is the value read or used for read purpose (at least, not only)
     */
    public function isExprRead(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        foreach ($this->readNodeAnalyzers as $readNodeAnalyzer) {
            if (!$readNodeAnalyzer->supports($expr)) {
                continue;
            }
            return $readNodeAnalyzer->isRead($expr);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException(\get_class($expr));
    }
}
