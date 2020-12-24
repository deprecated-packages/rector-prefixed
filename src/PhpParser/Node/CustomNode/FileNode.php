<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Inspired by https://github.com/phpstan/phpstan-src/commit/ed81c3ad0b9877e6122c79b4afda9d10f3994092
 */
final class FileNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract
{
    /**
     * @var Node[]
     */
    public $stmts = [];
    /**
     * @var SmartFileInfo
     */
    private $fileInfo;
    /**
     * @param Node[] $stmts
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, array $stmts)
    {
        parent::__construct();
        $this->fileInfo = $fileInfo;
        $this->stmts = $stmts;
    }
    public function getType() : string
    {
        return 'FileNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return ['stmts'];
    }
    public function getFileInfo() : \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->fileInfo;
    }
}
