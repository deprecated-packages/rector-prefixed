<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210504\Symfony\Component\HttpKernel\Fragment;

use RectorPrefix20210504\Symfony\Component\HttpFoundation\Request;
use RectorPrefix20210504\Symfony\Component\HttpFoundation\Response;
use RectorPrefix20210504\Symfony\Component\HttpKernel\Controller\ControllerReference;
use RectorPrefix20210504\Symfony\Component\HttpKernel\UriSigner;
use RectorPrefix20210504\Twig\Environment;
/**
 * Implements the Hinclude rendering strategy.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HIncludeFragmentRenderer extends \RectorPrefix20210504\Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer
{
    private $globalDefaultTemplate;
    private $signer;
    private $twig;
    private $charset;
    /**
     * @param string $globalDefaultTemplate The global default content (it can be a template name or the content)
     */
    public function __construct(\RectorPrefix20210504\Twig\Environment $twig = null, \RectorPrefix20210504\Symfony\Component\HttpKernel\UriSigner $signer = null, string $globalDefaultTemplate = null, string $charset = 'utf-8')
    {
        $this->twig = $twig;
        $this->globalDefaultTemplate = $globalDefaultTemplate;
        $this->signer = $signer;
        $this->charset = $charset;
    }
    /**
     * Checks if a templating engine has been set.
     *
     * @return bool true if the templating engine has been set, false otherwise
     */
    public function hasTemplating()
    {
        return null !== $this->twig;
    }
    /**
     * {@inheritdoc}
     *
     * Additional available options:
     *
     *  * default:    The default content (it can be a template name or the content)
     *  * id:         An optional hx:include tag id attribute
     *  * attributes: An optional array of hx:include tag attributes
     */
    public function render($uri, \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request $request, array $options = [])
    {
        if ($uri instanceof \RectorPrefix20210504\Symfony\Component\HttpKernel\Controller\ControllerReference) {
            if (null === $this->signer) {
                throw new \LogicException('You must use a proper URI when using the Hinclude rendering strategy or set a URL signer.');
            }
            // we need to sign the absolute URI, but want to return the path only.
            $uri = \substr($this->signer->sign($this->generateFragmentUri($uri, $request, \true)), \strlen($request->getSchemeAndHttpHost()));
        }
        // We need to replace ampersands in the URI with the encoded form in order to return valid html/xml content.
        $uri = \str_replace('&', '&amp;', $uri);
        $template = $options['default'] ?? $this->globalDefaultTemplate;
        if (null !== $this->twig && $template && $this->twig->getLoader()->exists($template)) {
            $content = $this->twig->render($template);
        } else {
            $content = $template;
        }
        $attributes = isset($options['attributes']) && \is_array($options['attributes']) ? $options['attributes'] : [];
        if (isset($options['id']) && $options['id']) {
            $attributes['id'] = $options['id'];
        }
        $renderedAttributes = '';
        if (\count($attributes) > 0) {
            $flags = \ENT_QUOTES | \ENT_SUBSTITUTE;
            foreach ($attributes as $attribute => $value) {
                $renderedAttributes .= \sprintf(' %s="%s"', \htmlspecialchars($attribute, $flags, $this->charset, \false), \htmlspecialchars($value, $flags, $this->charset, \false));
            }
        }
        return new \RectorPrefix20210504\Symfony\Component\HttpFoundation\Response(\sprintf('<hx:include src="%s"%s>%s</hx:include>', $uri, $renderedAttributes, $content));
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hinclude';
    }
}
