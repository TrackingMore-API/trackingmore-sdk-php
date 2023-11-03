<?php

namespace TrackingMore;

use TrackingMore\Interfaces\TrackingsInterface;

class Trackings implements TrackingsInterface {

    use Request;

    private $apiModule = 'trackings';

    public function createTracking($params = [])
    {
        if (empty($params['tracking_number'])) {
            throw new TrackingMoreException(ErrorMessages::ErrMissingTrackingNumber);
        }
        if (empty($params['courier_code'])) {
            throw new TrackingMoreException(ErrorMessages::ErrMissingCourierCode);
        }
        $this->apiPath = 'create';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

    public function getTrackingResults($params = [])
    {
        $paramsValue = http_build_query($params);
        $this->apiPath = "get?$paramsValue";
        $response = $this->sendApiRequest();
        return $response;
    }

    public function batchCreateTrackings($params = [])
    {
        if (count($params)>40) {
            throw new TrackingMoreException(ErrorMessages::ErrMaxTrackingNumbersExceeded);
        }
        for($i=0;$i<count($params);$i++){
              if(empty($params[$i]['tracking_number'])){
                throw new TrackingMoreException(ErrorMessages::ErrMissingTrackingNumber);
              }
              if(empty($params[$i]['courier_code'])){
                throw new TrackingMoreException(ErrorMessages::ErrMissingCourierCode);
              }
        }
        $this->apiPath = 'batch';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

    public function updateTrackingByID($idString ='', $params = [])
    {
        if (empty($idString)) {
            throw new TrackingMoreException(ErrorMessages::ErrEmptyId);
        }
        $this->apiPath = "update/$idString";
        $response = $this->sendApiRequest($params,'PUT');
        return $response;
    }

    public function deleteTrackingByID($idString ='')
    {
        if (empty($idString)) {
            throw new TrackingMoreException(ErrorMessages::ErrEmptyId);
        }
        $this->apiPath = "delete/$idString";
        $response = $this->sendApiRequest(null,'DELETE');
        return $response;
    }

    public function retrackTrackingByID($idString ='')
    {
        if (empty($idString)) {
            throw new TrackingMoreException(ErrorMessages::ErrEmptyId);
        }
        $this->apiPath = "retrack/$idString";
        $response = $this->sendApiRequest(null,'POST');
        return $response;
    }

}
