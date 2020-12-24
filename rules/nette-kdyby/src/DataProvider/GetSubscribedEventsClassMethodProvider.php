<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\DataProvider;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
final class GetSubscribedEventsClassMethodProvider
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return ClassMethod[]
     */
    public function provide() : array
    {
        return $this->nodeRepository->findClassMethodByTypeAndMethod('_PhpScoperb75b35f52b74\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents');
    }
}
