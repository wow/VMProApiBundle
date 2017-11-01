<?php

namespace MovingImage\Bundle\VMProApiBundle\EventListener;

use MovingImage\Bundle\VMProApiBundle\Service\Stopwatch;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Sets the headers with durations of each API request, as well as the total time for all requests.
 */
class StopwatchListener implements EventSubscriberInterface
{
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * @param Stopwatch $stopwatch
     */
    public function __construct(Stopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $totalDuration = 0;
        foreach ($this->stopwatch->getSections() as $section) {
            foreach ($section->getEvents() as $name => $stopwatchEvent) {
                $duration = $stopwatchEvent->getDuration();
                $totalDuration += $duration;
                $this->setHeader($event->getResponse(), $name, $duration);
            }
        }

        $this->setHeader($event->getResponse(), 'total', $totalDuration);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    /**
     * Sets the header for the specified stage (eg X-API-RESPONSE-GET-VIDEOS).
     *
     * @param Response $response
     * @param string   $stage
     * @param int      $duration
     */
    private function setHeader(Response $response, $stage, $duration)
    {
        $headerName = 'X-API-RESPONSE-'.strtoupper($stage);
        $response->headers->set($headerName, $duration);
    }
}
