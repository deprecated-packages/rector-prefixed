<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Parser;

use _PhpScoperb75b35f52b74\PhpParser\ErrorHandler;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use function array_key_exists;
use function hash;
use function strlen;
/**
 * @internal
 */
final class MemoizingParser implements \_PhpScoperb75b35f52b74\PhpParser\Parser
{
    /** @var Node\Stmt[][]|null[] indexed by source hash */
    private $sourceHashToAst = [];
    /** @var Parser */
    private $wrappedParser;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * {@inheritDoc}
     */
    public function parse(string $code, ?\_PhpScoperb75b35f52b74\PhpParser\ErrorHandler $errorHandler = null) : ?array
    {
        // note: this code is mathematically buggy by default, as we are using a hash to identify
        //       cache entries. The string length is added to further reduce likeliness (although
        //       already imperceptible) of key collisions.
        //       In the "real world", this code will work just fine.
        $hash = \hash('sha256', $code) . ':' . \strlen($code);
        if (\array_key_exists($hash, $this->sourceHashToAst)) {
            return $this->sourceHashToAst[$hash];
        }
        return $this->sourceHashToAst[$hash] = $this->wrappedParser->parse($code, $errorHandler);
    }
}
