<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\HttpCache;

use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request;
use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response;
interface SurrogateInterface
{
    /**
     * Returns surrogate name.
     *
     * @return string
     */
    public function getName();
    /**
     * Returns a new cache strategy instance.
     *
     * @return ResponseCacheStrategyInterface A ResponseCacheStrategyInterface instance
     */
    public function createCacheStrategy();
    /**
     * Checks that at least one surrogate has Surrogate capability.
     *
     * @return bool true if one surrogate has Surrogate capability, false otherwise
     */
    public function hasSurrogateCapability(\_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Adds Surrogate-capability to the given Request.
     */
    public function addSurrogateCapability(\_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Adds HTTP headers to specify that the Response needs to be parsed for Surrogate.
     *
     * This method only adds an Surrogate HTTP header if the Response has some Surrogate tags.
     */
    public function addSurrogateControl(\_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Checks that the Response needs to be parsed for Surrogate tags.
     *
     * @return bool true if the Response needs to be parsed, false otherwise
     */
    public function needsParsing(\_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Renders a Surrogate tag.
     *
     * @param string $uri          A URI
     * @param string $alt          An alternate URI
     * @param bool   $ignoreErrors Whether to ignore errors or not
     * @param string $comment      A comment to add as an esi:include tag
     *
     * @return string
     */
    public function renderIncludeTag($uri, $alt = null, $ignoreErrors = \true, $comment = '');
    /**
     * Replaces a Response Surrogate tags with the included resource content.
     *
     * @return Response
     */
    public function process(\_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request $request, \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Handles a Surrogate from the cache.
     *
     * @param string $uri          The main URI
     * @param string $alt          An alternative URI
     * @param bool   $ignoreErrors Whether to ignore errors or not
     *
     * @return string
     *
     * @throws \RuntimeException
     * @throws \Exception
     */
    public function handle(\_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\HttpCache\HttpCache $cache, $uri, $alt, $ignoreErrors);
}
