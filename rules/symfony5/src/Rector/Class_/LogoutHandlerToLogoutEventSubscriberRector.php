<?php

declare (strict_types=1);
namespace Rector\Symfony5\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\Symfony5\NodeFactory\OnLogoutClassMethodFactory;
use Rector\SymfonyCodeQuality\NodeFactory\GetSubscribedEventsClassMethodFactory;
use Rector\SymfonyCodeQuality\ValueObject\EventReferenceToMethodName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/36243
 *
 * @see \Rector\Symfony5\Tests\Rector\Class_\LogoutHandlerToLogoutEventSubscriberRector\LogoutHandlerToLogoutEventSubscriberRectorTest
 */
final class LogoutHandlerToLogoutEventSubscriberRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const LOGOUT_HANDLER_TYPE = 'Symfony\\Component\\Security\\Http\\Logout\\LogoutHandlerInterface';
    /**
     * @var OnLogoutClassMethodFactory
     */
    private $onLogoutClassMethodFactory;
    /**
     * @var GetSubscribedEventsClassMethodFactory
     */
    private $getSubscribedEventsClassMethodFactory;
    public function __construct(\Rector\Symfony5\NodeFactory\OnLogoutClassMethodFactory $onLogoutClassMethodFactory, \Rector\SymfonyCodeQuality\NodeFactory\GetSubscribedEventsClassMethodFactory $getSubscribedEventsClassMethodFactory)
    {
        $this->onLogoutClassMethodFactory = $onLogoutClassMethodFactory;
        $this->getSubscribedEventsClassMethodFactory = $getSubscribedEventsClassMethodFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change logout handler to an event listener that listens to LogoutEent', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class SomeLogoutHandler implements LogoutHandlerInterface
{
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class SomeLogoutHandler implements EventSubscriberInterface
{
    public function onLogout(LogoutEvent $logoutEvent): void
    {
        $request = $logoutEvent->getRequest();
        $response = $logoutEvent->getResponse();
        $token = $logoutEvent->getToken();
    }

    /**
     * @return array<string, string[]>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => ['onLogout'],
        ];
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, self::LOGOUT_HANDLER_TYPE)) {
            return null;
        }
        $this->refactorImplements($node);
        // 2. refactor logout() class method to onLogout()
        $logoutClassMethod = $node->getMethod('logout');
        if (!$logoutClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        $node->stmts[] = $this->onLogoutClassMethodFactory->createFromLogoutClassMethod($logoutClassMethod);
        $this->removeNode($logoutClassMethod);
        // 3. add getSubscribedEvents() class method
        $classConstFetch = $this->createClassConstReference('Symfony\\Component\\Security\\Http\\Event\\LogoutEvent');
        $eventReferencesToMethodNames = [new \Rector\SymfonyCodeQuality\ValueObject\EventReferenceToMethodName($classConstFetch, 'onLogout')];
        $getSubscribedEventsClassMethod = $this->getSubscribedEventsClassMethodFactory->create($eventReferencesToMethodNames);
        $node->stmts[] = $getSubscribedEventsClassMethod;
        return $node;
    }
    private function refactorImplements(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->implements[] = new \PhpParser\Node\Name\FullyQualified('Symfony\\Component\\EventDispatcher\\EventSubscriberInterface');
        foreach ($class->implements as $key => $implement) {
            if (!$this->isName($implement, self::LOGOUT_HANDLER_TYPE)) {
                continue;
            }
            unset($class->implements[$key]);
        }
    }
}
