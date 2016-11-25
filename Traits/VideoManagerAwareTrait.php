<?php

namespace MovingImage\Bundle\VMProApiBundle\Traits;

/**
 * Trait VideoManagerAwareTrait.
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
trait VideoManagerAwareTrait
{
    /**
     * @var int
     */
    private $defaultVideoManagerId;

    /**
     * {@inheritdoc}
     */
    public function setDefaultVideoManagerId($defaultVideoManagerId)
    {
        $this->defaultVideoManagerId = $defaultVideoManagerId;
    }

    /**
     * Ensure a videoManagerId, or throw an exception.
     *
     * @param int|null $overrideVideoManagerId
     *
     * @return int
     */
    protected function ensureVideoManagerId($overrideVideoManagerId = null)
    {
        if (!is_null($overrideVideoManagerId)) {
            return $overrideVideoManagerId;
        }

        if (is_null($this->defaultVideoManagerId)) {
            throw new \Exception('No default video manager configured..');
        }

        return $this->defaultVideoManagerId;
    }
}
