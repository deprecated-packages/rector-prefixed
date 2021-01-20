<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Parser;

use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Parser;
use ReflectionFunction;
use RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\PhpParser\Parser $parser, \RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parser = $parser;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function parseFunction(\ReflectionFunction $reflectionFunction) : ?\PhpParser\Node\Stmt\Namespace_
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
        if (!$firstNode instanceof \PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        return $firstNode;
    }
}
