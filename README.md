Trackingmore-PHP
=================

The PHP SDK of Trackingmore API

Contact: <manage@trackingmore.org>

## Official document

[Document](https://www.trackingmore.com/docs/trackingmore/d5ac362fc3cda-api-quick-start)

## Index
1. [Installation](https://github.com/TrackingMores/trackingmore-sdk-php#installation)
2. [Testing](https://github.com/TrackingMores/trackingmore-sdk-php#testing)
3. SDK
    1. [Couriers](https://github.com/TrackingMores/trackingmore-sdk-php#couriers)
    2. [Trackings](https://github.com/TrackingMores/trackingmore-sdk-php#trackings)
    3. [Air Waybill](https://github.com/TrackingMores/trackingmore-sdk-php#air-waybill)


## Installation
##### Option 1 (recommended): Download and Install Composer.

Run the following command to require TrackingMore PHP SDK
```
composer require trackingmore/trackingmore-sdk-php
```
Use autoloader to import SDK files
```php
require('vendor/autoload.php');

use Trackingmore\TrackingMoreException;
use TrackingMore\AirWaybills;
use TrackingMore\Couriers;
use TrackingMore\Trackings;

$key = 'you api key';

$response = null;

$couriers = new Couriers($key);
$trackings = new Trackings($key);
$airWaybill = new AirWaybills($key);

try {
    //Get all couriers (couriers/all)
    $response = $couriers->getAllCouriers();
} catch (TrackingMoreException $e) {
    echo $e->getMessage();
}

print_r($response);

```

##### Option 2: Manual installation
1. Download or clone this repository to desired location
2. Reference files of this SDK in your project. Absolute path should be prefered.

```php
<?php

require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/TrackingMoreException.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Request.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Interfaces/CouriersInterface.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Couriers.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Interfaces/TrackingsInterface.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Trackings.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/Interfaces/AirWaybillsInterface.php');
require(__DIR__ . '/trackingmore/trackingmore-sdk-php/src/AirWaybills.php');

$key = 'you api key';

$couriers = new TrackingMore\Couriers($key);
$trackings = new TrackingMore\Trackings($key);
$airWaybill = new TrackingMore\AirWaybills($key);

$response = null;

try {
    //Get all couriers (couriers/all)
    $response = $couriers->getAllCouriers();
} catch (TrackingMore\TrackingMoreException $e) {
    echo $e->getMessage();
}

print_r($response);

```

## Testing
1. Execute the file:
 * If you are install manually, please execute 'trackingmore/trackingmore-sdk-php/examples/testing.php' on your browser.
 * If you are install by composer, please execute 'vendor/trackingmore/trackingmore-sdk-php/examples/testing.php' on your browser.
2. Insert your TrackingMore API Key. [How to generate TrackingMore API Key](https://www.trackingmore.com/tracking-api)
3. Click the request all button or the button of the represented request.

## Error handling

Simply add a try-catch block

```php
try {
  $couriers = new TrackingMore\Couriers('you api key');
  $response = $couriers->getAllCouriers();
}catch(\TrackingMoreException $e) {
    echo $e->getMessage();
}

```

## Couriers
##### Return a list of all supported couriers.
https://api.trackingmore.com/v4/couriers/all
```php
$couriers = new TrackingMore\Couriers('you api key');
$response = $couriers->getAllCouriers();
```

##### Return a list of matched couriers based on submitted tracking number.
https://api.trackingmore.com/v4/couriers/detect
```php
$couriers = new TrackingMore\Couriers('you api key');
$params = ['tracking_number'=>'92612903029511573030094531'];
$response = $couriers->detect($params);
```

## Trackings
##### Create a tracking.
https://api.trackingmore.com/v4/trackings/create
```php
$trackings = new TrackingMore\Trackings('you api key');
$params = ['tracking_number'=>'9400111899562537624646','courier_code'=>'usps'];
$response = $trackings->createTracking($params);
```

##### Get tracking results of multiple trackings.
https://api.trackingmore.com/v4/trackings/get
```php
$trackings = new TrackingMore\Trackings('you api key');                                                  
// Perform queries based on various conditions
$params = ['tracking_number'=>'92612903029511573030094531'];
$params = ['tracking_numbers'=>'92612903029511573030094532','courier_code'=>'usps'];
$params = ['tracking_numbers'=>'92612903029511573030094531,9400111899562539126562','courier_code'=>'usps'];
$params = ['created_date_min'=>'2023-08-23T06:00:00+00:00','created_date_max'=>'2023-09-05T07:20:42+00:00'];
$response = $trackings->getTrackingResults($params);
```

##### Create multiple trackings (Max. 40 tracking numbers create in one call).
https://api.trackingmore.com/v4/trackings/batch
```php
$trackings = new TrackingMore\Trackings('you api key');
$params = [
    ['tracking_number'=>'92612903029511573030094531','courier_code'=>'usps'],
    ['tracking_number'=>'92612903029511573030094532','courier_code'=>'usps']
];
$response = $trackings->batchCreateTrackings($params);
```

##### Update a tracking by ID.
https://api.trackingmore.com/v4/trackings/update/{id}
```php
$trackings = new TrackingMore\Trackings('you api key');
$params = ['customer_name'=>'New name','note'=>'New tests order note'];
$idString = '9a035f5cdd0437c55d48e223c705a66c';
$response = $trackings->updateTrackingByID($idString,$params);
```

##### Delete a tracking by ID.
https://api.trackingmore.com/v4/trackings/delete/{id}
```php
$trackings = new TrackingMore\Trackings('you api key');
$idString = '99f8a21408be0b436705aa84d6f91806';
$response = $trackings->deleteTrackingByID($idString);
```

##### Retrack expired tracking by ID.
https://api.trackingmore.com/v4/trackings/retrack/{id}
```php
$trackings = new TrackingMore\Trackings('you api key');
$idString = '9a035f5cdd0437c55d48e223c705a66c';
$response = $trackings->retrackTrackingByID($idString);
```
## Air Waybill
##### Create an air waybill.
https://api.trackingmore.com/v4/awb
```php
$airWaybill = new TrackingMore\AirWaybills('you api key');
$params = ['awb_number'=>'235-69030430'];
$response = $airWaybill->createAnAirWayBill($params);
```

## Response Code

Trackingmore uses conventional HTTP response codes to indicate success or failure of an API request. In general, codes in the 2xx range indicate success, codes in the 4xx range indicate an error that resulted from the provided information (e.g. a required parameter was missing, a charge failed, etc.), and codes in the 5xx range indicate an TrackingMore's server error.


Http CODE|META CODE|TYPE | MESSAGE
----|-----|--------------|-------------------------------
200    |200     | <code>Success</code>        |    Request response is successful
400    |400     | <code>BadRequest</code>     |    Request type error. Please check the API documentation for the request type of this API.
400    |4101    | <code>BadRequest</code>     |    Tracking No. already exists.
400    |4102    | <code>BadRequest</code>     |    Tracking No. no exists. Please use 「Create a tracking」 API first to create shipment.
400    |4103    | <code>BadRequest</code>     |    You have exceeded the shipment quantity of API call. The maximum quantity is 40 shipments per call.
400    |4110    | <code>BadRequest</code>     |    The value of tracking_number is invalid.
400    |4111    | <code>BadRequest</code>     |    Tracking_number is required.
400    |4112    | <code>BadRequest</code>     |    Invalid Tracking ID.
400    |4113    | <code>BadRequest</code>     |    Retrack is not allowed. You can only retrack an expired tracking.
400    |4120    | <code>BadRequest</code>     |    The value of courier_code is invalid.
400    |4121    | <code>BadRequest</code>     |    Cannot detect courier.
400    |4122    | <code>BadRequest</code>     |    Missing or invalid value of the special required fields for this courier.
400    |4130    | <code>BadRequest</code>     |    The format of Field name is invalid.
400    |4160    | <code>BadRequest</code>     |    The awb_number is required or invaild format.
400    |4161    | <code>BadRequest</code>     |    The awb airline does not support yet.
400    |4190    | <code>BadRequest</code>     |    You are reaching the maximum quota limitation, please upgrade your current plan.
401    |401     | <code>Unauthorized</code>   |    Authentication failed or has no permission. Please check and ensure your API Key is correct.
403    |403     | <code>Forbidden</code>      |    Access prohibited. The request has been refused or access is not allowed.
404    |404     | <code>NotFound</code>       |    Page does not exist. Please check and ensure your link is correct.
429    |429     | <code>TooManyRequests</code>|    Exceeded API request limits, please try again later. Please check the API documentation for the limit of this API.
500    |511     | <code>ServerError</code>    |    Server error. Please contact us: service@trackingmore.org.
500    |512     | <code>ServerError</code>    |    Server error. Please contact us: service@trackingmore.org.
500    |513     | <code>ServerError</code>    |    Server error. Please contact us: service@trackingmore.org.