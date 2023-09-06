<?php

namespace TrackingMore;

use TrackingMore\Interfaces\AirWaybillsInterface;

class AirWaybills implements AirWaybillsInterface {

    use Request;

    private $apiModule;

    public function createAnAirWayBill($params = [])
    {
        if (empty($params['awb_number'])) {
            throw new TrackingMoreException('Awb number cannot be empty');
        }
        $this->apiPath = 'awb';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

}
