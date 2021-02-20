<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\NodeFactory;

use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NetteToSymfony\NodeFactory\ActionWithFormProcessClassMethodFactory $actionWithFormProcessClassMethodFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->actionWithFormProcessClassMethodFactory = $actionWithFormProcessClassMethodFactory;
    }
    public function createNamespace(\PhpParser\Node\Stmt\Class_ $node, \PhpParser\Node\Stmt\Class_ $formTypeClass) : ?\PhpParser\Node\Stmt\Namespace_
    {
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210220\Symplify\SmartFileSystem\SmartFileInfo) {
            return null;
        }
        /** @var string $namespaceName */
        $namespaceName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        $formControllerClass = new \PhpParser\Node\Stmt\Class_('SomeFormController');
        $formControllerClass->extends = new \PhpParser\Node\Name\FullyQualified('Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController');
        $formTypeClass = $namespaceName . '\\' . $this->nodeNameResolver->getName($formTypeClass);
        $formControllerClass->stmts[] = $this->actionWithFormProcessClassMethodFactory->create($formTypeClass);
        $namespace = new \PhpParser\Node\Stmt\Namespace_(new \PhpParser\Node\Name($namespaceName));
        $namespace->stmts[] = $formControllerClass;
        return $namespace;
    }
}
