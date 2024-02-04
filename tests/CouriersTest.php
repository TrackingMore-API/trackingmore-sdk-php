<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TrackingMore\Couriers;
use TrackingMore\ErrorMessages;
use TrackingMore\TrackingMoreException;

class CouriersTest extends TestCase
{

    /** @var Couriers */
    private $couriers;

    protected function setUp()
    {
        parent::setUp();
        $this->couriers = new Couriers('your api key');
    }

    /** @tests */
    public function testApiKeysExist(){
        try {
            new Couriers();
        } catch (TrackingMoreException $e) {
            $this->assertInstanceOf(TrackingMoreException::class, $e);
            $this->assertEquals($e->getMessage(), ErrorMessages::ErrEmptyAPIKey);
        }
    }

    /** @tests */
    public function testGetAllCouriers()
    {
        $response = $this->couriers->getAllCouriers();
        $this->assertInternalType('array',$response);
    }

    /** @tests */
    public function testDetect()
    {
        $trackingNumber = 'ABC123456789';
        $response = $this->couriers->detect(['tracking_number' => $trackingNumber]);
        $this->assertInternalType('array', $response);
    }

    /** @test */
    public function testTrackingNumberCantBeEmpty()
    {
        $this->throwsError('detect', [''], ErrorMessages::ErrMissingTrackingNumber);
    }

    private function throwsError($method, $args, $errorMessage)
    {

        try {
            call_user_func_array([$this->couriers, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(TrackingMoreException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }

}