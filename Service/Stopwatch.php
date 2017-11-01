<?php

namespace MovingImage\Bundle\VMProApiBundle\Service;

use MovingImage\Client\VMPro\Interfaces\StopwatchInterface;
use Symfony\Component\Stopwatch\Stopwatch as SymfonyStopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Adapter for Symfony Stopwatch, implementing the StopwatchInterface.
 */
class Stopwatch implements StopwatchInterface
{
    /**
     * @var SymfonyStopwatch
     */
    private $delegate;

    /**
     * @var StopwatchEvent[]
     */
    private $events = [];

    /**
     * @param SymfonyStopwatch $delegate
     */
    public function __construct(SymfonyStopwatch $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritdoc}
     */
    public function start($name, $category = null)
    {
        $this->delegate->start($name, $category);
    }

    /**
     * {@inheritdoc}
     */
    public function stop($name)
    {
        $this->events[$name] = $this->delegate->stop($name);
    }

    /**
     * @return StopwatchEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }
}
