<?php

declare (strict_types=1);
namespace Rector\Legacy\Rector\FileWithoutNamespace;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/rectorphp/rector/issues/3679
 *
 * @see \Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector\AddTopIncludeRectorTest
 */
final class AddTopIncludeRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds an include file at the top of matching files, except class definitions', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        if (!$this->isFileInfoMatch($smartFileInfo->getRelativeFilePath())) {
            return null;
        }
        $stmts = $node->stmts;
        // we are done if there is a class definition in this file
        if ($this->betterNodeFinder->hasInstancesOf($stmts, [\PhpParser\Node\Stmt\Class_::class])) {
            return null;
        }
        if ($this->hasIncludeAlready($stmts)) {
            return null;
        }
        // add the include to the statements and print it
        \array_unshift($stmts, new \PhpParser\Node\Stmt\Nop());
        \array_unshift($stmts, new \PhpParser\Node\Stmt\Expression($this->createInclude()));
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
        $includes = $this->betterNodeFinder->findInstanceOf($nodes, \PhpParser\Node\Expr\Include_::class);
        foreach ($includes as $include) {
            if ($this->isTopFileInclude($include)) {
                return \true;
            }
        }
        return \false;
    }
    private function createInclude() : \PhpParser\Node\Expr\Include_
    {
        $filePathConcat = new \PhpParser\Node\Expr\BinaryOp\Concat(new \PhpParser\Node\Scalar\MagicConst\Dir(), new \PhpParser\Node\Scalar\String_($this->autoloadFilePath));
        return new \PhpParser\Node\Expr\Include_($filePathConcat, \PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE);
    }
    private function isTopFileInclude(\PhpParser\Node\Expr\Include_ $include) : bool
    {
        return $this->areNodesEqual($include->expr, $this->createInclude()->expr);
    }
}
