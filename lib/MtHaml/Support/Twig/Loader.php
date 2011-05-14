<?php

namespace MtHaml\Support\Twig;

use MtHaml\Environment;

class Loader implements \Twig_LoaderInterface
{
    protected $env;
    protected $loader;

    public function __construct(Environment $env, \Twig_LoaderInterface $loader)
    {
        $this->env = $env;
        $this->loader = $loader;
    }

    public function getSource($name)
    {
        $source = $this->loader->getSource($name);
        if (strncmp($source, '{% haml %}', 10) === 0) {
            $source = substr($source, 10);
            $source = $this->env->compileString($source, $name);
        }
        return $source;
    }

    public function getCacheKey($name)
    {
        return $this->loader->getCacheKey($name);
    }

    public function isFresh($name, $time)
    {
        return $this->loader->isFresh($name, $time);
    }

    public function setPaths($paths)
    {
        if (method_exists($this->loader, 'setPaths')) {
            $this->loader->setPaths($paths);
        }
    }
} 
