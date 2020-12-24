<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\DataProvider;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
final class GetSubscribedEventsClassMethodProvider
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return ClassMethod[]
     */
    public function provide() : array
    {
        return $this->nodeRepository->findClassMethodByTypeAndMethod('_PhpScopere8e811afab72\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents');
    }
}
