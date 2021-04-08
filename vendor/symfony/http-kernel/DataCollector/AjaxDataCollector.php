<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\HttpKernel\DataCollector;

use RectorPrefix20210408\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210408\Symfony\Component\HttpFoundation\Response;
/**
 * AjaxDataCollector.
 *
 * @author Bart van den Burg <bart@burgov.nl>
 *
 * @final
 */
class AjaxDataCollector extends \RectorPrefix20210408\Symfony\Component\HttpKernel\DataCollector\DataCollector
{
    /**
     * @param \Throwable $exception
     */
    public function collect(\RectorPrefix20210408\Symfony\Component\HttpFoundation\Request $request, \RectorPrefix20210408\Symfony\Component\HttpFoundation\Response $response, $exception = null)
    {
        // all collecting is done client side
    }
    public function reset()
    {
        // all collecting is done client side
    }
    public function getName()
    {
        return 'ajax';
    }
}
