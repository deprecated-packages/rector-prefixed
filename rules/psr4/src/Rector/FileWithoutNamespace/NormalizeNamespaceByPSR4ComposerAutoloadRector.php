<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PSR4\Rector\FileWithoutNamespace;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use _PhpScopere8e811afab72\Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\NormalizeNamespaceByPSR4ComposerAutoloadRectorTest
 */
final class NormalizeNamespaceByPSR4ComposerAutoloadRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PSR4AutoloadNamespaceMatcherInterface
     */
    private $psr4AutoloadNamespaceMatcher;
    public function __construct(\_PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface $psr4AutoloadNamespaceMatcher)
    {
        $this->psr4AutoloadNamespaceMatcher = $psr4AutoloadNamespaceMatcher;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $description = \sprintf('Adds namespace to namespace-less files or correct namespace to match PSR-4 in `composer.json` autoload section. Run with combination with "%s"', \_PhpScopere8e811afab72\Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector::class);
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition($description, [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample(<<<'CODE_SAMPLE'
// src/SomeClass.php

class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// src/SomeClass.php

namespace App\CustomNamespace;

class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
{
    "autoload": {
        "psr-4": {
            "App\\CustomNamespace\\": "src"
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $expectedNamespace = $this->psr4AutoloadNamespaceMatcher->getExpectedNamespace($node);
        if ($expectedNamespace === null) {
            return null;
        }
        // is namespace and already correctly named?
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ && $this->isName($node, $expectedNamespace)) {
            return null;
        }
        // to put declare_strict types on correct place
        if ($node instanceof \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            return $this->refactorFileWithoutNamespace($node, $expectedNamespace);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($expectedNamespace);
            $this->makeNamesFullyQualified((array) $node->stmts);
        }
        return $node;
    }
    private function refactorFileWithoutNamespace(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace $fileWithoutNamespace, string $expectedNamespace) : \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace
    {
        $nodes = $fileWithoutNamespace->stmts;
        $nodesWithStrictTypesThenNamespace = [];
        foreach ($nodes as $key => $fileWithoutNamespace) {
            if ($fileWithoutNamespace instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Declare_) {
                $nodesWithStrictTypesThenNamespace[] = $fileWithoutNamespace;
                unset($nodes[$key]);
            }
        }
        $namespace = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_(new \_PhpScopere8e811afab72\PhpParser\Node\Name($expectedNamespace), (array) $nodes);
        $nodesWithStrictTypesThenNamespace[] = $namespace;
        $this->makeNamesFullyQualified((array) $nodes);
        // @todo update to a new class node, like FileWithNamespace
        return new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($nodesWithStrictTypesThenNamespace);
    }
    /**
     * @param Stmt[] $nodes
     */
    private function makeNamesFullyQualified(array $nodes) : void
    {
        // no need to
        if ($this->parameterProvider->provideBoolParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES)) {
            return;
        }
        // FQNize all class names
        $this->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?FullyQualified {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($this->getName($node));
        });
    }
}
