<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\Parser;
use _PhpScoper0a2ac50786fa\PhpParser\ParserFactory;
use _PhpScoper0a2ac50786fa\PhpParser\PrettyPrinter\Standard;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor;
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
        $this->parser = (new \_PhpScoper0a2ac50786fa\PhpParser\ParserFactory())->create(\_PhpScoper0a2ac50786fa\PhpParser\ParserFactory::PREFER_PHP7);
        $this->standard = new \_PhpScoper0a2ac50786fa\PhpParser\PrettyPrinter\Standard();
    }
    public function suffixContent(string $content, string $classSuffix) : string
    {
        /** @var Node[] $nodes */
        $nodes = $this->parser->parse($content);
        // collect all class, trait, interface local names, e.g. class <name>, interface <name>
        $classLikeNameCollectingNodeVisitor = new \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor\ClassLikeNameCollectingNodeVisitor();
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($classLikeNameCollectingNodeVisitor);
        $nodeTraverser->traverse($nodes);
        $classLikeNames = $classLikeNameCollectingNodeVisitor->getClassLikeNames();
        // replace those class names in code
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor\PrefixingClassLikeNamesNodeVisitor($classLikeNames, $classSuffix));
        $nodes = $nodeTraverser->traverse($nodes);
        return $this->standard->prettyPrintFile($nodes);
    }
}
