<?php
require( '../../../autoload.php' );
$action      = isset( $_GET['action'] ) ? $_GET['action'] : '';
$api_key     = isset( $_GET['api_key'] ) ? $_GET['api_key'] : 'Tracking-Api-Key';
$request_all = ( $action == 'ALL' );

function pr_result( callable $func, $parse_json = true ) {
	try {
		$response = $func();
		// somehow if the array too large json_encode will break... so use print_r for walk-around
		$result   = $parse_json ? json_encode( $response, JSON_PRETTY_PRINT ) : print_r( $response, true );
	} catch ( Exception $e ) {
		$result = $e->getMessage();
	}
	?>
    <div class="response">
        <pre style="max-height: 400px"><code class="language-json"><?= ( $result ) ?></code></pre>
    </div>
	<?php
}

?>
<html>
<head>
    <title>Testing</title>
    <!-- CSS -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{
            border-radius: 0px;
        }
    </style>
    <!-- jQuery and JavaScript Bundle with Popper -->
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.slim.js" ></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript">
        $(function () {
            $(".btn").click(function () {
                var value = $(this).val();
                $("#hidden").val(value);
                $("#form").submit();
            });
        });
    </script>
</head>

<body>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">TrackingMore API PHP SDK Testing</h1>
        <p class="lead">This is the official PHP SDK of TrackingMore API. Provided by TrackingMore</p>
        <hr class="my-4">
        <a href="mailto:manage@trackingmore.org">manage@trackingmore.org</a>
    </div>
</div>
<!---->
<main class="container">
    <form action="testing.php" method="GET" id="form" class="form">
        <div class="form-group">
            <label for="api_key">API KEY:</label>
            <input value="<?= $api_key ?>" name="api_key" id="api_key" size="45" class="form-control"/>
            <div class="help-block">
                <a href="https://www.trackingmore.com/tracking-api" target="_blank">How to generate TrackingMore API
                    Key?</a>
            </div>
        </div>
        <hr class="my-4">
        <button type="submit" value="ALL" class="btn btn-primary">Request All</button>
        <hr class="my-4">
        <div class="help-block">CURRENT ACTION: <?= $action ?></div>

		<?php if ( ! $api_key ): ?>
            <b class="text-danger">Please input API key first</b>
			<?php exit ?>
		<?php endif; ?>

        <hr>

        <input type="hidden" name="action" id="hidden"/>

		<?php
		$couriers         = new \TrackingMore\Couriers( $api_key );
		$trackings        = new \TrackingMore\Trackings( $api_key );
		$airWaybill = new \TrackingMore\AirWaybills( $api_key );
		?>

        <h2>Couriers</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td style="width: 200px">Description</td>
                <td style="width: 240px">Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Get all couriers (couriers/all)</td>
                <td>
                    <input type="button" value="v4/couriers/all" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/couriers/all' ) {
						pr_result( function () use ( $couriers ) {
							return $couriers->getAllCouriers();
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Detect courier (couriers/detect)</td>
                <td>
                    <input type="button" value="v4/couriers/detect" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/couriers/detect' ) {
						pr_result( function () use ( $couriers ) {
                            $params = ['tracking_number'=>'92612903029511573030094531'];
							return $couriers->detect($params);
						});
					} ?>
                </td>
            </tr>
            </tbody>
        </table>


        <h2>Trackings</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td style="width: 200px">Description</td>
                <td style="width: 240px">Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Create a Tracking (trackings/create)</td>
                <td>
                    <input type="button" value="v4/trackings/create" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/trackings/create' ) {
						pr_result( function () use ( $trackings ) {
                            $params = [
                                'tracking_number'=>'9400111899562537624646',
                                'courier_code'=>'usps',
                                'order_number'=>'',
                                'customer_name'=>'',
                                'title'=>'',
                                'language'=>'en',
                                'note'=>'tests Order'
                            ];
                            return $trackings->createTracking($params);
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Get results (trackings/get)</td>
                <td>
                    <input type="button" value="v4/trackings/get" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/trackings/get' ) {
						pr_result( function () use ( $trackings ) {
                            $params = ['tracking_numbers'=>'92612903029511573030094532','courier_code'=>'usps'];
							return $trackings->getTrackingResults($params);
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Create trackings (trackings/batch)</td>
                <td>
                    <input type="button" value="v4/trackings/batch" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_delete_by_id' ) {
						pr_result( function () use ( $trackings ) {
                            $params = [
                                ['tracking_number'=>'92612903029511573030094531','courier_code'=>'usps'],
                                ['tracking_number'=>'92612903029511573030094532','courier_code'=>'usps']
                            ];
							return $trackings->batchCreateTrackings( $params);
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Update a Tracking by ID (trackings/update)</td>
                <td>
                    <input type="button" value="v4/trackings/update" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_get' ) {
						pr_result( function () use ( $trackings ) {
                            $params = ['customer_name'=>'New name','note'=>'New tests order note'];
                            $idString = '99f8a21408be0b436705aa84d6f91806';
							return $trackings->updateTrackingByID($idString,$params);
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Delete Tracking by ID (trackings/delete)</td>
                <td>
                    <input type="button" value="v4/trackings/delete" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/trackings/delete' ) {
						pr_result( function () use ( $trackings ) {
                            $idString = '99f8a21408be0b436705aa84d6f91806';
							return $trackings->deleteTrackingByID($idString);
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>Retrack expired Tracking by ID (trackings/retrack)</td>
                <td>
                    <input type="button" value="v4/trackings/retrack" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/trackings/retrack' ) {
						pr_result( function () use ( $trackings ) {
                            $idString = '99f8a21408be0b436705aa84d6f91806';
							return $trackings->retrackTrackingByID( $idString);
						} );
					} ?>
                </td>
            </tr>
            </tbody>
        </table>


        <h2>Air Waybill</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td style="width: 200px">Description</td>
                <td style="width: 240px">Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Create an air waybill (awb)</td>
                <td>
                    <input type="button" value="v4/awb" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'v4/awb' ) {
						pr_result( function () use ( $airWaybill ) {
                            $params = ['awb_number'=>'235-69030430'];
							return $airWaybill->createAnAirWayBill($params);
						} );
					} ?>
                </td>
            </tr>

            </tbody>
        </table>

    </form>
</main>
</body>
</html>
