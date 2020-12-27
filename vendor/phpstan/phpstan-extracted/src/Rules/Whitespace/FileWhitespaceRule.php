<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Whitespace;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\FileNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<FileNode>
 */
class FileWhitespaceRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\FileNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $nodes = $node->getNodes();
        if (\count($nodes) === 0) {
            return [];
        }
        $firstNode = $nodes[0];
        $messages = [];
        if ($firstNode instanceof \PhpParser\Node\Stmt\InlineHTML && $firstNode->value === "﻿") {
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('File begins with UTF-8 BOM character. This may cause problems when running the code in the web browser.')->build();
        }
        $nodeTraverser = new \PhpParser\NodeTraverser();
        $visitor = new class extends \PhpParser\NodeVisitorAbstract
        {
            /** @var \PhpParser\Node[] */
            private $lastNodes = [];
            /**
             * @param Node $node
             * @return int|Node|null
             */
            public function enterNode(\PhpParser\Node $node)
            {
                if ($node instanceof \PhpParser\Node\Stmt\Declare_) {
                    if ($node->stmts !== null && \count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                if ($node instanceof \PhpParser\Node\Stmt\Namespace_) {
                    if (\count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                return \PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            /**
             * @return Node[]
             */
            public function getLastNodes() : array
            {
                return $this->lastNodes;
            }
        };
        $nodeTraverser->addVisitor($visitor);
        $nodeTraverser->traverse($nodes);
        $lastNodes = $visitor->getLastNodes();
        $lastNodes[] = $nodes[\count($nodes) - 1];
        foreach ($lastNodes as $lastNode) {
            if (!$lastNode instanceof \PhpParser\Node\Stmt\InlineHTML || \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings::match($lastNode->value, '#^(\\s+)$#') === null) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.')->line($lastNode->getStartLine())->build();
        }
        return $messages;
    }
}
