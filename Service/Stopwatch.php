<?php

namespace MovingImage\Bundle\VMProApiBundle\Service;

use MovingImage\Client\VMPro\Interfaces\StopwatchInterface;

/**
 * Adapter for Symfony Stopwatch, implementing the StopwatchInterface.
 */
class Stopwatch extends \Symfony\Component\Stopwatch\Stopwatch implements StopwatchInterface
{
}
