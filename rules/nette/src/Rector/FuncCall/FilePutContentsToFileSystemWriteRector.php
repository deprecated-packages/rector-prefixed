<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\FuncCall\FilePutContentsToFileSystemWriteRector\FilePutContentsToFileSystemWriteRectorTest
 */
final class FilePutContentsToFileSystemWriteRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change file_put_contents() to FileSystem::write()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        file_put_contents('file.txt', 'content');

        file_put_contents('file.txt', 'content_to_append', FILE_APPEND);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        \Nette\Utils\FileSystem::write('file.txt', 'content');

        file_put_contents('file.txt', 'content_to_append', FILE_APPEND);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node, 'file_put_contents')) {
            return null;
        }
        if (\count((array) $node->args) !== 2) {
            return null;
        }
        return $this->createStaticCall('_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'write', $node->args);
    }
}
