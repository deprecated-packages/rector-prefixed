<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SymfonyControllerFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ActionWithFormProcessClassMethodFactory
     */
    private $actionWithFormProcessClassMethodFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NetteToSymfony\NodeFactory\ActionWithFormProcessClassMethodFactory $actionWithFormProcessClassMethodFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->actionWithFormProcessClassMethodFactory = $actionWithFormProcessClassMethodFactory;
    }
    public function createNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $formTypeClass) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo === null) {
            return null;
        }
        /** @var string $namespaceName */
        $namespaceName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        $formControllerClass = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_('SomeFormController');
        $formControllerClass->extends = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        $formTypeClass = $namespaceName . '\\' . $this->nodeNameResolver->getName($formTypeClass);
        $formControllerClass->stmts[] = $this->actionWithFormProcessClassMethodFactory->create($formTypeClass);
        $namespace = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($namespaceName));
        $namespace->stmts[] = $formControllerClass;
        return $namespace;
    }
}
