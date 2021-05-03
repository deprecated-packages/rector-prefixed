<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This code is partially based on the Rack-Cache library by Ryan Tomayko,
 * which is released under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210503\Symfony\Component\HttpKernel\HttpCache;

use RectorPrefix20210503\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210503\Symfony\Component\HttpFoundation\Response;
/**
 * Interface implemented by HTTP cache stores.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface StoreInterface
{
    /**
     * Locates a cached Response for the Request provided.
     *
     * @return Response|null A Response instance, or null if no cache entry was found
     */
    public function lookup(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Writes a cache entry to the store for the given Request and Response.
     *
     * Existing entries are read and any that match the response are removed. This
     * method calls write with the new list of cache entries.
     *
     * @return string The key under which the response is stored
     */
    public function write(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix20210503\Symfony\Component\HttpFoundation\Response $response);
    /**
     * Invalidates all cache entries that match the request.
     */
    public function invalidate(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Locks the cache for a given Request.
     *
     * @return bool|string true if the lock is acquired, the path to the current lock otherwise
     */
    public function lock(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Releases the lock for the given Request.
     *
     * @return bool False if the lock file does not exist or cannot be unlocked, true otherwise
     */
    public function unlock(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Returns whether or not a lock exists.
     *
     * @return bool true if lock exists, false otherwise
     */
    public function isLocked(\RectorPrefix20210503\Symfony\Component\HttpFoundation\Request $request);
    /**
     * Purges data for the given URL.
     *
     * @return bool true if the URL exists and has been purged, false otherwise
     */
    public function purge(string $url);
    /**
     * Cleanups storage.
     */
    public function cleanup();
}
