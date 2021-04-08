<?php

declare (strict_types=1);
namespace Rector\Core\Application;

use Rector\Core\Contract\Rector\RectorInterface;
use Rector\PostRector\Contract\Rector\PostRectorInterface;
use RectorPrefix20210408\Symplify\Skipper\Skipper\Skipper;
/**
 * Provides list of Rector rules, that are not internal → only those registered by user
 */
final class ActiveRectorsProvider
{
    /**
     * @var RectorInterface[]
     */
    private $rectors = [];
    /**
     * @param RectorInterface[] $rectors
     */
    public function __construct(array $rectors, \RectorPrefix20210408\Symplify\Skipper\Skipper\Skipper $skipper)
    {
        foreach ($rectors as $key => $rector) {
            if ($skipper->shouldSkipElement($rector)) {
                unset($rectors[$key]);
            }
        }
        $this->rectors = $rectors;
    }
    /**
     * @template T as RectorInterface
     * @param class-string<T> $type
     * @return array<T>
     */
    public function provideByType(string $type) : array
    {
        return \array_filter($this->rectors, function (\Rector\Core\Contract\Rector\RectorInterface $rector) use($type) : bool {
            return \is_a($rector, $type, \true);
        });
    }
    /**
     * @return RectorInterface[]
     */
    public function provide() : array
    {
        return $this->filterOutInternalRectorsAndSort($this->rectors);
    }
    /**
     * @param RectorInterface[] $rectors
     * @return RectorInterface[]
     */
    private function filterOutInternalRectorsAndSort(array $rectors) : array
    {
        \sort($rectors);
        $rectors = \array_filter($rectors, function (\Rector\Core\Contract\Rector\RectorInterface $rector) : bool {
            // skip as internal and always run
            return !$rector instanceof \Rector\PostRector\Contract\Rector\PostRectorInterface;
        });
        \usort($rectors, function (\Rector\Core\Contract\Rector\RectorInterface $firstRector, \Rector\Core\Contract\Rector\RectorInterface $secondRector) : int {
            return \get_class($firstRector) <=> \get_class($secondRector);
        });
        return $rectors;
    }
}
