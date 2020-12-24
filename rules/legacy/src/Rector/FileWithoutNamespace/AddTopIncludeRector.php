<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Legacy\Rector\FileWithoutNamespace;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/rectorphp/rector/issues/3679
 *
 * @see \Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector\AddTopIncludeRectorTest
 */
final class AddTopIncludeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const PATTERNS = '$patterns';
    /**
     * @api
     * @var string
     */
    public const AUTOLOAD_FILE_PATH = '$autoloadFilePath';
    /**
     * @var string
     */
    private $autoloadFilePath = '/autoload.php';
    /**
     * @var string[]
     */
    private $patterns = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds an include file at the top of matching files, except class definitions', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
if (isset($_POST['csrf'])) {
    processPost($_POST);
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
require_once __DIR__ . '/../autoloader.php';

if (isset($_POST['csrf'])) {
    processPost($_POST);
}
CODE_SAMPLE
, [self::AUTOLOAD_FILE_PATH => '/../autoloader.php', self::PATTERNS => ['pat*/*/?ame.php', 'somepath/?ame.php']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        if (!$this->isFileInfoMatch($smartFileInfo->getRelativeFilePath())) {
            return null;
        }
        $stmts = $node->stmts;
        // we are done if there is a class definition in this file
        if ($this->betterNodeFinder->hasInstancesOf($stmts, [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class])) {
            return null;
        }
        if ($this->hasIncludeAlready($stmts)) {
            return null;
        }
        // add the include to the statements and print it
        \array_unshift($stmts, new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop());
        \array_unshift($stmts, new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($this->createInclude()));
        $node->stmts = $stmts;
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->patterns = $configuration[self::PATTERNS] ?? [];
        $this->autoloadFilePath = $configuration[self::AUTOLOAD_FILE_PATH] ?? '/autoload.php';
    }
    /**
     * Match file against matches, no patterns provided, then it matches
     */
    private function isFileInfoMatch(string $path) : bool
    {
        if ($this->patterns === []) {
            return \true;
        }
        foreach ($this->patterns as $pattern) {
            if (\fnmatch($pattern, $path, \FNM_NOESCAPE)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * Find all includes and see if any match what we want to insert
     * @param Node[] $nodes
     */
    private function hasIncludeAlready(array $nodes) : bool
    {
        /** @var Include_[] $includes */
        $includes = $this->betterNodeFinder->findInstanceOf($nodes, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_::class);
        foreach ($includes as $include) {
            if ($this->isTopFileInclude($include)) {
                return \true;
            }
        }
        return \false;
    }
    private function createInclude() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_
    {
        $filePathConcat = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst\Dir(), new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($this->autoloadFilePath));
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_($filePathConcat, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE);
    }
    private function isTopFileInclude(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_ $include) : bool
    {
        return $this->areNodesEqual($include->expr, $this->createInclude()->expr);
    }
}
