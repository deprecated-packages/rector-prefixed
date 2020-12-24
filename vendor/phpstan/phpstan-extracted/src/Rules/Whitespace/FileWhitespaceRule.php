<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Whitespace;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\FileNode;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<FileNode>
 */
class FileWhitespaceRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\FileNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $nodes = $node->getNodes();
        if (\count($nodes) === 0) {
            return [];
        }
        $firstNode = $nodes[0];
        $messages = [];
        if ($firstNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\InlineHTML && $firstNode->value === "﻿") {
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('File begins with UTF-8 BOM character. This may cause problems when running the code in the web browser.')->build();
        }
        $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
        $visitor = new class extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
        {
            /** @var \PhpParser\Node[] */
            private $lastNodes = [];
            /**
             * @param Node $node
             * @return int|Node|null
             */
            public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
            {
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Declare_) {
                    if ($node->stmts !== null && \count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
                    if (\count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
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
            if (!$lastNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\InlineHTML || \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($lastNode->value, '#^(\\s+)$#') === null) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message('File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.')->line($lastNode->getStartLine())->build();
        }
        return $messages;
    }
}
