<?php

namespace MovingImage\Bundle\VMProApiBundle\Service;

use MovingImage\Bundle\VMProApiBundle\Interfaces\ApiClientAwareInterface;
use MovingImage\Bundle\VMProApiBundle\Interfaces\VideoManagerAwareInterface;
use MovingImage\Bundle\VMProApiBundle\Traits\ApiClientAwareTrait;
use MovingImage\Bundle\VMProApiBundle\Traits\VideoManagerAwareTrait;
use MovingImage\Client\VMPro\Interfaces\ApiClientInterface;

abstract class AbstractService implements ApiClientAwareInterface , VideoManagerAwareInterface
{
    use ApiClientAwareTrait;
    use VideoManagerAwareTrait;

    public function __construct(ApiClientInterface $apiClient, $defaultVideoManagerId = null)
    {
        $this->setApiClient($apiClient);
        $this->setDefaultVideoManagerId($defaultVideoManagerId);
    }
}
