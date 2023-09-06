<?php

namespace TrackingMore\Interfaces;

interface CouriersInterface
{

    /**
     * Return a list of all supported couriers.
     * @return mixed
     */
    public function getAllCouriers();

    /**
     * Return a list of matched couriers based on submitted tracking number.
     * @param array $params
     * @return mixed
     */
    public function detect($params = []);

}