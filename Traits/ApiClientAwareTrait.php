<?php

namespace MovingImage\Bundle\VMProApiBundle\Traits;

use MovingImage\Client\VMPro\Interfaces\ApiClientInterface;

/**
 * Trait ApiClientWareTrait.
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
trait ApiClientWareTrait
{
    /**
     * @var ApiClientInterface
     */
    private $apiClient;

    /**
     * {@inheritdoc}
     */
    public function setApiClient(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return ApiClientInterface
     */
    protected function getApiClient()
    {
        return $this->apiClient;
    }
}
