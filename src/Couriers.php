<?php

namespace TrackingMore;


use TrackingMore\Interfaces\CouriersInterface;

class Couriers implements CouriersInterface {

    use Request;

    private $apiModule = 'couriers';

    public function getAllCouriers()
    {
        $this->apiPath = 'all';
        $response = $this->sendApiRequest();
        return $response;
    }

    public function detect($params = [])
    {
        if (empty($params['tracking_number'])) {
            throw new TrackingMoreException('Tracking number cannot be empty');
        }
        $this->apiPath = 'detect';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

}
