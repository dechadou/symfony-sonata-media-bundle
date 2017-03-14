<?php

namespace MediaMonks\SonataMediaBundle\Provider;

use MediaMonks\SonataMediaBundle\Model\MediaInterface;

class ProviderPool
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @param $name
     * @return AbstractProvider
     */
    public function getProvider($name)
    {
        return $this->providers[$name];
    }

    /**
     * @param AbstractProvider $provider
     */
    public function addProvider(AbstractProvider $provider)
    {
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * @param $providers
     */
    public function setProviders($providers)
    {
        $this->providers = $providers;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param MediaInterface $media
     * @return AbstractProvider
     */
    public function getByMedia(MediaInterface $media)
    {
        return $this->getProvider($media->getProvider());
    }
}
