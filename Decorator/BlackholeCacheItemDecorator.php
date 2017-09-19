<?php

namespace MovingImage\Bundle\VMProApiBundle\Decorator;

use Psr\Cache\CacheItemInterface;

/**
 * Decorator that wraps around any CacheItemInterface implementation
 * and overrides the `isHit` method by always returning false.
 * Therefore, this is a CacheItem implementation useful for forcing cache to be refreshed.
 */
class BlackholeCacheItemDecorator implements CacheItemInterface
{
    /**
     * Decorated CacheItem implementation.
     *
     * @var CacheItemInterface
     */
    private $cacheItem;

    /**
     * @param CacheItemInterface $cacheItem
     */
    public function __construct(CacheItemInterface $cacheItem)
    {
        $this->cacheItem = $cacheItem;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->cacheItem->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->cacheItem->get();
    }

    /**
     * {@inheritdoc}
     */
    public function isHit()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function set($value)
    {
        return $this->cacheItem->set($value);
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAt($expiration)
    {
        return $this->cacheItem->expiresAt($expiration);
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter($time)
    {
        return $this->cacheItem->expiresAfter($time);
    }

    /**
     * Returns the decorated CacheItemInterface implementation.
     *
     * @return CacheItemInterface
     */
    public function getDecoratedItem()
    {
        return $this->cacheItem;
    }
}
