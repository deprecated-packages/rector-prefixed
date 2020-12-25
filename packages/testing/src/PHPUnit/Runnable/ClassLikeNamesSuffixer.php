<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit\Runnable;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor;
use Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor;
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
        $this->parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);
        $this->standard = new \PhpParser\PrettyPrinter\Standard();
    }
    public function suffixContent(string $content, string $classSuffix) : string
    {
        /** @var Node[] $nodes */
        $nodes = $this->parser->parse($content);
        // collect all class, trait, interface local names, e.g. class <name>, interface <name>
        $classLikeNameCollectingNodeVisitor = new \Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor();
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($classLikeNameCollectingNodeVisitor);
        $nodeTraverser->traverse($nodes);
        $classLikeNames = $classLikeNameCollectingNodeVisitor->getClassLikeNames();
        // replace those class names in code
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor($classLikeNames, $classSuffix));
        $nodes = $nodeTraverser->traverse($nodes);
        return $this->standard->prettyPrintFile($nodes);
    }
}
