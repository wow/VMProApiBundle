<?php

namespace MovingImage\Bundle\VMProApiBundle\Interfaces;

use MovingImage\Client\VMPro\Interfaces\ApiClientInterface;

/**
 * Interface ApiClientAwareInterface
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
interface ApiClientAwareInterface
{
    /**
     * Set the VMPro API client.
     *
     * @param ApiClientInterface $apiClient
     */
    public function setApiClient(ApiClientInterface $apiClient);
}
