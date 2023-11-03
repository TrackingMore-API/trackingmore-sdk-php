<?php

namespace TrackingMore;

use TrackingMore\Interfaces\AirWaybillsInterface;

class AirWaybills implements AirWaybillsInterface {

    use Request;

    private $apiModule;

    public function createAnAirWayBill($params = [])
    {
        if (empty($params['awb_number'])) {
            throw new TrackingMoreException(ErrorMessages::ErrMissingAwbNumber);
        }
        if(!preg_match('/^\d{3}[ -]?(\d{8})$/',$params['awb_number'])){
            throw new TrackingMoreException(ErrorMessages::ErrInvalidAirWaybillFormat);
        }
        $this->apiPath = 'awb';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

}
