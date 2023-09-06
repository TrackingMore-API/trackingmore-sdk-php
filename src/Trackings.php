<?php

namespace TrackingMore;

use TrackingMore\Interfaces\TrackingsInterface;

class Trackings implements TrackingsInterface {

    use Request;

    private $apiModule = 'trackings';

    public function createTracking($params = [])
    {
        if (empty($params['tracking_number'])) {
            throw new TrackingMoreException('Tracking number cannot be empty');
        }
        if (empty($params['courier_code'])) {
            throw new TrackingMoreException('Courier Code cannot be empty');
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
            throw new TrackingMoreException('Max. 40 tracking numbers create in one call');
        }
        $this->apiPath = 'batch';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

    public function updateTrackingByID($idString ='', $params = [])
    {
        if (empty($idString)) {
            throw new TrackingMoreException('Id cannot be empty');
        }
        $this->apiPath = "update/$idString";
        $response = $this->sendApiRequest($params,'PUT');
        return $response;
    }

    public function deleteTrackingByID($idString ='')
    {
        if (empty($idString)) {
            throw new TrackingMoreException('Id cannot be empty');
        }
        $this->apiPath = "delete/$idString";
        $response = $this->sendApiRequest(null,'DELETE');
        return $response;
    }

    public function retrackTrackingByID($idString ='')
    {
        if (empty($idString)) {
            throw new TrackingMoreException('Id cannot be empty');
        }
        $this->apiPath = "retrack/$idString";
        $response = $this->sendApiRequest(null,'POST');
        return $response;
    }

}
