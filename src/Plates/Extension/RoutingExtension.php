<?php

namespace Rych\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension implements ExtensionInterface
{

    private $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('url', [$this, 'getUrl']);
        $engine->registerFunction('path', [$this, 'getPath']);
    }

    public function getUrl($name, $parameters = array (), $schemeRelative = false)
    {
        return $this->generator->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getPath($name, $parameters = array (), $relative = false)
    {
        return $this->generator->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

}

