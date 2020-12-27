<?php

declare (strict_types=1);
namespace PHPStan\Rules\Whitespace;

use _HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<FileNode>
 */
class FileWhitespaceRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\FileNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $nodes = $node->getNodes();
        if (\count($nodes) === 0) {
            return [];
        }
        $firstNode = $nodes[0];
        $messages = [];
        if ($firstNode instanceof \PhpParser\Node\Stmt\InlineHTML && $firstNode->value === "﻿") {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message('File begins with UTF-8 BOM character. This may cause problems when running the code in the web browser.')->build();
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
            if (!$lastNode instanceof \PhpParser\Node\Stmt\InlineHTML || \_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($lastNode->value, '#^(\\s+)$#') === null) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message('File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.')->line($lastNode->getStartLine())->build();
        }
        return $messages;
    }
}
