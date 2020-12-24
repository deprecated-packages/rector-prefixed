<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
/**
 * Inspired by https://github.com/phpstan/phpstan-src/commit/ed81c3ad0b9877e6122c79b4afda9d10f3994092
 */
final class FileWithoutNamespace extends \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract
{
    /**
     * @var Stmt[]
     */
    public $stmts = [];
    /**
     * @param Stmt[] $stmts
     */
    public function __construct(array $stmts)
    {
        $this->stmts = $stmts;
        parent::__construct();
    }
    public function getType() : string
    {
        return 'FileWithoutNamespace';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return ['stmts'];
    }
}
