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
        if(strlen($params['awb_number']) != 12){
            throw new TrackingMoreException('The air waybill number format is invalid and can only be 12 digits in length');
        }
        $this->apiPath = 'awb';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

}
