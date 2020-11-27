<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Fragment;

use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request;
use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Controller\ControllerReference;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\UriSigner;
use _PhpScoper006a73f0e455\Symfony\Component\Templating\EngineInterface;
use _PhpScoper006a73f0e455\Twig\Environment;
use _PhpScoper006a73f0e455\Twig\Error\LoaderError;
use _PhpScoper006a73f0e455\Twig\Loader\ExistsLoaderInterface;
use _PhpScoper006a73f0e455\Twig\Loader\SourceContextLoaderInterface;
/**
 * Implements the Hinclude rendering strategy.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HIncludeFragmentRenderer extends \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer
{
    private $globalDefaultTemplate;
    private $signer;
    private $templating;
    private $charset;
    /**
     * @param EngineInterface|Environment $templating            An EngineInterface or a Twig instance
     * @param string                      $globalDefaultTemplate The global default content (it can be a template name or the content)
     */
    public function __construct($templating = null, \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\UriSigner $signer = null, string $globalDefaultTemplate = null, string $charset = 'utf-8')
    {
        $this->setTemplating($templating);
        $this->globalDefaultTemplate = $globalDefaultTemplate;
        $this->signer = $signer;
        $this->charset = $charset;
    }
    /**
     * Sets the templating engine to use to render the default content.
     *
     * @param EngineInterface|Environment|null $templating An EngineInterface or an Environment instance
     *
     * @throws \InvalidArgumentException
     *
     * @internal
     */
    public function setTemplating($templating)
    {
        if (null !== $templating && !$templating instanceof \_PhpScoper006a73f0e455\Symfony\Component\Templating\EngineInterface && !$templating instanceof \_PhpScoper006a73f0e455\Twig\Environment) {
            throw new \InvalidArgumentException('The hinclude rendering strategy needs an instance of Twig\\Environment or Symfony\\Component\\Templating\\EngineInterface.');
        }
        if ($templating instanceof \_PhpScoper006a73f0e455\Symfony\Component\Templating\EngineInterface) {
            @\trigger_error(\sprintf('Using a "%s" instance for "%s" is deprecated since version 4.3; use a \\Twig\\Environment instance instead.', \_PhpScoper006a73f0e455\Symfony\Component\Templating\EngineInterface::class, __CLASS__), \E_USER_DEPRECATED);
        }
        $this->templating = $templating;
    }
    /**
     * Checks if a templating engine has been set.
     *
     * @return bool true if the templating engine has been set, false otherwise
     */
    public function hasTemplating()
    {
        return null !== $this->templating;
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
    public function render($uri, \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request $request, array $options = [])
    {
        if ($uri instanceof \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Controller\ControllerReference) {
            if (null === $this->signer) {
                throw new \LogicException('You must use a proper URI when using the Hinclude rendering strategy or set a URL signer.');
            }
            // we need to sign the absolute URI, but want to return the path only.
            $uri = \substr($this->signer->sign($this->generateFragmentUri($uri, $request, \true)), \strlen($request->getSchemeAndHttpHost()));
        }
        // We need to replace ampersands in the URI with the encoded form in order to return valid html/xml content.
        $uri = \str_replace('&', '&amp;', $uri);
        $template = isset($options['default']) ? $options['default'] : $this->globalDefaultTemplate;
        if (null !== $this->templating && $template && $this->templateExists($template)) {
            $content = $this->templating->render($template);
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
        return new \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response(\sprintf('<hx:include src="%s"%s>%s</hx:include>', $uri, $renderedAttributes, $content));
    }
    private function templateExists(string $template) : bool
    {
        if ($this->templating instanceof \_PhpScoper006a73f0e455\Symfony\Component\Templating\EngineInterface) {
            try {
                return $this->templating->exists($template);
            } catch (\Exception $e) {
                return \false;
            }
        }
        $loader = $this->templating->getLoader();
        if (1 === \_PhpScoper006a73f0e455\Twig\Environment::MAJOR_VERSION && !$loader instanceof \_PhpScoper006a73f0e455\Twig\Loader\ExistsLoaderInterface) {
            try {
                if ($loader instanceof \_PhpScoper006a73f0e455\Twig\Loader\SourceContextLoaderInterface) {
                    $loader->getSourceContext($template);
                } else {
                    $loader->getSource($template);
                }
                return \true;
            } catch (\_PhpScoper006a73f0e455\Twig\Error\LoaderError $e) {
            }
            return \false;
        }
        return $loader->exists($template);
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hinclude';
    }
}
