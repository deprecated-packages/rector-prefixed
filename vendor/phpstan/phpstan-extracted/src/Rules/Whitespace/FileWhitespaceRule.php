<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Whitespace;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\FileNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<FileNode>
 */
class FileWhitespaceRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\FileNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $nodes = $node->getNodes();
        if (\count($nodes) === 0) {
            return [];
        }
        $firstNode = $nodes[0];
        $messages = [];
        if ($firstNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\InlineHTML && $firstNode->value === "﻿") {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('File begins with UTF-8 BOM character. This may cause problems when running the code in the web browser.')->build();
        }
        $nodeTraverser = new \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser();
        $visitor = new class extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
        {
            /** @var \PhpParser\Node[] */
            private $lastNodes = [];
            /**
             * @param Node $node
             * @return int|Node|null
             */
            public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
            {
                if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Declare_) {
                    if ($node->stmts !== null && \count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
                    if (\count($node->stmts) > 0) {
                        $this->lastNodes[] = $node->stmts[\count($node->stmts) - 1];
                    }
                    return null;
                }
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
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
            if (!$lastNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\InlineHTML || \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($lastNode->value, '#^(\\s+)$#') === null) {
                continue;
            }
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('File ends with a trailing whitespace. This may cause problems when running the code in the web browser. Remove the closing ?> mark or remove the whitespace.')->line($lastNode->getStartLine())->build();
        }
        return $messages;
    }
}
