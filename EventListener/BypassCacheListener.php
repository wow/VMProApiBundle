<?php

namespace MovingImage\Bundle\VMProApiBundle\EventListener;

use MovingImage\Bundle\VMProApiBundle\Decorator\BlackholeCacheItemPoolDecorator;
use MovingImage\Client\VMPro\ApiClient;
use MovingImage\Client\VMPro\ApiClient\AbstractApiClient;
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
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var string|null
     */
    private $cacheBypassArgument;

    /**
     * @param ApiClient $apiClient
     * @param string    $cacheBypassArgument
     */
    public function __construct(ApiClient $apiClient, $cacheBypassArgument = null)
    {
        $this->apiClient = $apiClient;
        $this->cacheBypassArgument = $cacheBypassArgument;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (is_null($this->cacheBypassArgument)) {
            return;
        }

        $request = $event->getRequest();
        if ($request->get($this->cacheBypassArgument) || $request->cookies->get($this->cacheBypassArgument)) {
            /** @var AbstractApiClient $apiClient */
            $cachePool = new BlackholeCacheItemPoolDecorator($this->apiClient->getCacheItemPool());
            $this->apiClient->setCacheItemPool($cachePool);
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
