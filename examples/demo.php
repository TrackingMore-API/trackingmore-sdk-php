<?php

require( '../../../autoload.php' );

use Trackingmore\TrackingMoreException;
use TrackingMore\AirWaybills;
use TrackingMore\Couriers;
use TrackingMore\Trackings;

$key = '';

$response = null;

$couriers = new Couriers($key);
$airWaybill = new AirWaybills($key);
$trackings = new Trackings($key);

try {
    //Get all couriers (couriers/all)
    $response = $couriers->getAllCouriers();
} catch (TrackingMoreException $e) {
    echo $e->getMessage();
}
//
//try {
//    //Detect courier (couriers/detect)
//    $params = ['tracking_number'=>'92612903029511573030094531'];
//    $response = $couriers->detect($params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Create an air waybill (awb)
//    $params = ['awb_number'=>'235-69030430'];
//    $response = $airWaybill->createAnAirWayBill($params);
//    $response = $couriers->detect($params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Create a Tracking (trackings/create)
//    $params = ['tracking_number'=>'9400111899562537624646','courier_code'=>'usps','order_number'=>'','customer_name'=>'','title'=>'','language'=>'en','note'=>'tests Order'];
//    $response = $trackings->createTracking($params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Get results (trackings/get)
//    $params = ['tracking_numbers'=>'92612903029511573030094532','courier_code'=>'usps'];
//    $params = ['tracking_numbers'=>'92612903029511573030094531,9400111899562539126562','courier_code'=>'usps'];
//    $params = ['created_date_min'=>'2023-08-23T06:00:00+00:00','created_date_max'=>'2023-09-05T07:20:42+00:00'];
//    $response = $trackings->getTrackingResults($params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Create trackings (trackings/batch)
//    $params = [
//        ['tracking_number'=>'92612903029511573030094531','courier_code'=>'usps'],
//        ['tracking_number'=>'92612903029511573030094532','courier_code'=>'usps']
//    ];
//    $response = $trackings->batchCreateTrackings($params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Update a Tracking by ID (trackings/update)
//    $params = ['customer_name'=>'New name','note'=>'New tests order note'];
//    $idString = '';
//    $response = $trackings->updateTrackingByID($idString,$params);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Delete Tracking by ID (trackings/delete)
//    $idString = '99f8a21408be0b436705aa84d6f91806';
//    $response = $trackings->deleteTrackingByID($idString);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}
//
//try {
//    //Retrack expired Tracking by ID (trackings/retrack)
//    $idString = '9a035f5cdd0437c55d48e223c705a66c';
//    $response = $trackings->retrackTrackingByID($idString);
//} catch (TrackingMoreException $e) {
//    echo $e->getMessage();
//}

print_r($response);
die;

