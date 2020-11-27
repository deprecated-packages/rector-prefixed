<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\JMS\DiExtraBundle\Annotation;

// @see https://github.com/schmittjoh/JMSDiExtraBundle/blob/master/Annotation/InjectParams.php
if (\class_exists('_PhpScoper88fe6e0ad041\\JMS\\DiExtraBundle\\Annotation\\InjectParams')) {
    return;
}
/**
 * @Annotation
 * @Target("METHOD")
 */
final class InjectParams
{
    /**
     * @var \JMS\DiExtraBundle\Annotation\Inject[]
     */
    public $params = [];
}
