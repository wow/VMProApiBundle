<?php

namespace MovingImage\Bundle\VMProApiBundle\EventListener;

use MovingImage\Bundle\VMProApiBundle\Decorator\BlackholeCacheItemPoolDecorator;
use MovingImage\Client\VMPro\ApiClient\AbstractApiClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * This listener kicks in only if the `cache_bypass_argument` bundle config option is set.
 * If the request contains an argument matching the value configured in the aforementioned config option
 * and the value of that argument evaluates to true, this listener will modify the cache pool implementation
 * used by the VMPro API client, by decorating it with a blackhole cache implementation:
 * one that stores responses to cache, but never returns a hit.
 */
class BypassCacheListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string|null
     */
    private $cacheBypassArgument;

    /**
     * @param ContainerInterface $container
     * @param string             $cacheBypassArgument
     */
    public function __construct(ContainerInterface $container, $cacheBypassArgument = null)
    {
        $this->container = $container;
        $this->cacheBypassArgument = $cacheBypassArgument;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$this->cacheBypassArgument) {
            return;
        }

        $request = $event->getRequest();

        if ($request->get($this->cacheBypassArgument)) {
            /** @var AbstractApiClient $apiClient */
            $apiClient = $this->container->get('vmpro_api.client');
            $cachePool = new BlackholeCacheItemPoolDecorator($apiClient->getCacheItemPool());
            $apiClient->setCacheItemPool($cachePool);
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
