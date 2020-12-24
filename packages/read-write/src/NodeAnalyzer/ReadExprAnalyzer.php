<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\ReadWrite\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\ReadWrite\Contract\ReadNodeAnalyzerInterface;
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
    public function isExprRead(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        foreach ($this->readNodeAnalyzers as $readNodeAnalyzer) {
            if (!$readNodeAnalyzer->supports($expr)) {
                continue;
            }
            return $readNodeAnalyzer->isRead($expr);
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException(\get_class($expr));
    }
}
