<?php

namespace MediaMonks\SonataMediaBundle\Twig\Extension;

use MediaMonks\SonataMediaBundle\Generator\UrlGenerator;
use MediaMonks\SonataMediaBundle\Provider\ProviderInterface;
use MediaMonks\SonataMediaBundle\Provider\ProviderPool;
use MediaMonks\SonataMediaBundle\Helper\Parameter;
use MediaMonks\SonataMediaBundle\Model\MediaInterface;

class MediaExtension extends \Twig_Extension
{
    /**
     * @var ProviderPool
     */
    private $providerPool;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @param ProviderPool $providerPool
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(ProviderPool $providerPool, UrlGenerator $urlGenerator)
    {
        $this->providerPool = $providerPool;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'media';
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'media', [$this, 'media'], [
                    'needs_environment' => true,
                    'is_safe'           => ['html'],
                ]
            ),
            new \Twig_SimpleFilter(
                'media_image', [$this, 'mediaImage'], [
                    'needs_environment' => true,
                    'is_safe'           => ['html'],
                ]
            ),
            new \Twig_SimpleFilter(
                'media_type', [$this, 'mediaType']
            ),
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @param MediaInterface $media
     * @param $width
     * @param $height
     * @param array $parameters
     * @param null $routeName
     * @return string
     */
    public function media(
        \Twig_Environment $environment,
        MediaInterface $media,
        $width,
        $height,
        array $parameters = [],
        $routeName = null
    ) {
        return $environment->render(
            $this->getProviderByMedia($media)->getMediaTemplate(),
            [
                'media'      => $media,
                'width'      => $width,
                'height'     => $height,
                'routeName'  => $routeName,
                'parameters' => $parameters,
            ]
        );
    }

    /**
     * @param \Twig_Environment $environment
     * @param MediaInterface $media
     * @param $width
     * @param $height
     * @param array $parameters
     * @param null $routeName
     * @return string
     */
    public function mediaImage(
        \Twig_Environment $environment,
        MediaInterface $media,
        $width,
        $height,
        array $parameters = [],
        $routeName = null
    ) {
        $parameters += [
            'w' => $width,
            'h' => $height,
        ];

        return sprintf(
            '<img src="%s" width="%d" height="%d" title="%s">',
            $this->urlGenerator->generate($media, $parameters, $routeName),
            $width,
            $height,
            twig_escape_filter($environment, $media->getTitle()) // @todo check if this is now escaped properly
        );
    }

    /**
     * @param MediaInterface $media
     * @return string
     */
    public function mediaType(MediaInterface $media)
    {
        return $this->getProviderByMedia($media)->getName();
    }

    /**
     * @param MediaInterface $media
     * @return ProviderInterface
     */
    private function getProviderByMedia(MediaInterface $media)
    {
        return $this->providerPool->getProvider($media->getProviderName());
    }
}
