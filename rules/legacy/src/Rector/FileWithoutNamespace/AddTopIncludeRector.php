<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Legacy\Rector\FileWithoutNamespace;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/rectorphp/rector/issues/3679
 *
 * @see \Rector\Legacy\Tests\Rector\FileWithoutNamespace\AddTopIncludeRector\AddTopIncludeRectorTest
 */
final class AddTopIncludeRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds an include file at the top of matching files, except class definitions', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $smartFileInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        if (!$this->isFileInfoMatch($smartFileInfo->getRelativeFilePath())) {
            return null;
        }
        $stmts = $node->stmts;
        // we are done if there is a class definition in this file
        if ($this->betterNodeFinder->hasInstancesOf($stmts, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class])) {
            return null;
        }
        if ($this->hasIncludeAlready($stmts)) {
            return null;
        }
        // add the include to the statements and print it
        \array_unshift($stmts, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Nop());
        \array_unshift($stmts, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($this->createInclude()));
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
        $includes = $this->betterNodeFinder->findInstanceOf($nodes, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_::class);
        foreach ($includes as $include) {
            if ($this->isTopFileInclude($include)) {
                return \true;
            }
        }
        return \false;
    }
    private function createInclude() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_
    {
        $filePathConcat = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\MagicConst\Dir(), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($this->autoloadFilePath));
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_($filePathConcat, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE);
    }
    private function isTopFileInclude(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_ $include) : bool
    {
        return $this->areNodesEqual($include->expr, $this->createInclude()->expr);
    }
}
