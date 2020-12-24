<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NetteToSymfony\NodeFactory\ActionWithFormProcessClassMethodFactory $actionWithFormProcessClassMethodFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->actionWithFormProcessClassMethodFactory = $actionWithFormProcessClassMethodFactory;
    }
    public function createNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $formTypeClass) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo === null) {
            return null;
        }
        /** @var string $namespaceName */
        $namespaceName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        $formControllerClass = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_('SomeFormController');
        $formControllerClass->extends = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        $formTypeClass = $namespaceName . '\\' . $this->nodeNameResolver->getName($formTypeClass);
        $formControllerClass->stmts[] = $this->actionWithFormProcessClassMethodFactory->create($formTypeClass);
        $namespace = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($namespaceName));
        $namespace->stmts[] = $formControllerClass;
        return $namespace;
    }
}
