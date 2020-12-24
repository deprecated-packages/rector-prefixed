<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\Parser;
use _PhpScopere8e811afab72\PhpParser\ParserFactory;
use _PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor;
final class ClassLikeNamesSuffixer
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Standard
     */
    private $standard;
    public function __construct()
    {
        $this->parser = (new \_PhpScopere8e811afab72\PhpParser\ParserFactory())->create(\_PhpScopere8e811afab72\PhpParser\ParserFactory::PREFER_PHP7);
        $this->standard = new \_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard();
    }
    public function suffixContent(string $content, string $classSuffix) : string
    {
        /** @var Node[] $nodes */
        $nodes = $this->parser->parse($content);
        // collect all class, trait, interface local names, e.g. class <name>, interface <name>
        $classLikeNameCollectingNodeVisitor = new \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor();
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($classLikeNameCollectingNodeVisitor);
        $nodeTraverser->traverse($nodes);
        $classLikeNames = $classLikeNameCollectingNodeVisitor->getClassLikeNames();
        // replace those class names in code
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor($classLikeNames, $classSuffix));
        $nodes = $nodeTraverser->traverse($nodes);
        return $this->standard->prettyPrintFile($nodes);
    }
}
