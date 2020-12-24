<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Parser;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Parser;
use ReflectionFunction;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
final class FunctionParser
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Parser $parser, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function parseFunction(\ReflectionFunction $reflectionFunction) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_
    {
        $fileName = $reflectionFunction->getFileName();
        if (!\is_string($fileName)) {
            return null;
        }
        $functionCode = $this->smartFileSystem->readFile($fileName);
        if (!\is_string($functionCode)) {
            return null;
        }
        $nodes = (array) $this->parser->parse($functionCode);
        $firstNode = $nodes[0] ?? null;
        if (!$firstNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        return $firstNode;
    }
}
