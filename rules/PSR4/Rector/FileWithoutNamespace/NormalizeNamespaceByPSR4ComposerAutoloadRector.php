<?php

declare(strict_types=1);

namespace Rector\PSR4\Rector\FileWithoutNamespace;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\Core\Rector\AbstractRector;
use Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
use Rector\PSR4\NodeManipulator\FullyQualifyStmtsAnalyzer;
use Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ComposerJsonAwareCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\NormalizeNamespaceByPSR4ComposerAutoloadRectorTest
 */
final class NormalizeNamespaceByPSR4ComposerAutoloadRector extends AbstractRector
{
    /**
     * @var PSR4AutoloadNamespaceMatcherInterface
     */
    private $psr4AutoloadNamespaceMatcher;

    /**
     * @var FullyQualifyStmtsAnalyzer
     */
    private $fullyQualifyStmtsAnalyzer;

    public function __construct(
        PSR4AutoloadNamespaceMatcherInterface $psr4AutoloadNamespaceMatcher,
        FullyQualifyStmtsAnalyzer $fullyQualifyStmtsAnalyzer
    ) {
        $this->psr4AutoloadNamespaceMatcher = $psr4AutoloadNamespaceMatcher;
        $this->fullyQualifyStmtsAnalyzer = $fullyQualifyStmtsAnalyzer;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        $description = sprintf(
            'Adds namespace to namespace-less files or correct namespace to match PSR-4 in `composer.json` autoload section. Run with combination with "%s"',
            MultipleClassFileToPsr4ClassesRector::class
        );

        return new RuleDefinition($description, [
            new ComposerJsonAwareCodeSample(
                <<<'CODE_SAMPLE'
// src/SomeClass.php

class SomeClass
{
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
// src/SomeClass.php

namespace App\CustomNamespace;

class SomeClass
{
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
{
    "autoload": {
        "psr-4": {
            "App\\CustomNamespace\\": "src"
        }
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Namespace_::class, FileWithoutNamespace::class];
    }

    /**
     * @param FileWithoutNamespace|Namespace_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $expectedNamespace = $this->psr4AutoloadNamespaceMatcher->getExpectedNamespace($this->file, $node);
        if ($expectedNamespace === null) {
            return null;
        }

        // is namespace and already correctly named?
        if ($node instanceof Namespace_ && $this->isName($node, $expectedNamespace)) {
            return null;
        }

        // to put declare_strict types on correct place
        if ($node instanceof FileWithoutNamespace) {
            return $this->refactorFileWithoutNamespace($node, $expectedNamespace);
        }

        $node->name = new Name($expectedNamespace);
        $this->fullyQualifyStmtsAnalyzer->process($node->stmts);

        return $node;
    }

    private function refactorFileWithoutNamespace(
        FileWithoutNamespace $fileWithoutNamespace,
        string $expectedNamespace
    ): FileWithoutNamespace {
        $nodes = $fileWithoutNamespace->stmts;

        $nodesWithStrictTypesThenNamespace = [];
        foreach ($nodes as $key => $fileWithoutNamespace) {
            if ($fileWithoutNamespace instanceof Declare_) {
                $nodesWithStrictTypesThenNamespace[] = $fileWithoutNamespace;
                unset($nodes[$key]);
            }
        }

        $namespace = new Namespace_(new Name($expectedNamespace), $nodes);
        $nodesWithStrictTypesThenNamespace[] = $namespace;

        $this->fullyQualifyStmtsAnalyzer->process($nodes);

        // @todo update to a new class node, like FileWithNamespace
        return new FileWithoutNamespace($nodesWithStrictTypesThenNamespace);
    }
}
