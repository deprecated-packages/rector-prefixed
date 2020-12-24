<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Parser;
use ReflectionFunction;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Parser $parser, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function parseFunction(\ReflectionFunction $reflectionFunction) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_
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
        if (!$firstNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        return $firstNode;
    }
}
