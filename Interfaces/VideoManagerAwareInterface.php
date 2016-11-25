<?php

namespace MovingImage\Bundle\VMProApiBundle\Interfaces;

/**
 * Interface VideoManagerAwareInterface.
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
interface VideoManagerAwareInterface
{
    /**
     * Set the default video manager ID
     *
     * @param int|null $defaultVideoManagerId
     */
    public function setDefaultVideoManagerId($defaultVideoManagerId);
}
