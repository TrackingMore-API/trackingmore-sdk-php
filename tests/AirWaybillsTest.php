<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TrackingMore\AirWaybills;
use TrackingMore\TrackingMoreException;

class AirWaybillsTest extends TestCase
{

    /** @var AirWaybills */
    private $airWaybills;

    protected function setUp()
    {
        parent::setUp();
        $this->airWaybills = new AirWaybills('you api key');
    }

    /** @tests */
    public function testApiKeysExist(){
        try {
            new AirWaybills();
        } catch (TrackingMoreException $e) {
            $this->assertInstanceOf(TrackingMoreException::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @tests */
    public function testCreateAnAirWayBill()
    {
        $airNumber = 'ABC123456789';
        $response = $this->airWaybills->createAnAirWayBill(['awb_number'=>$airNumber]);
        $this->assertInternalType('array',$response);
    }

    /** @test */
    public function testAwbNumberCantBeEmpty()
    {
        $this->throwsError('createAnAirWayBill', [''], 'Awb number cannot be empty');
    }

    /** @test */
    public function testCreateAnAirWayBillWithInvalidAwbNumberFormat()
    {
        $this->throwsError('createAnAirWayBill', [['awb_number'=>'123456']], 'The air waybill number format is invalid and can only be 12 digits in length');
    }

    private function throwsError($method, $args, $errorMessage)
    {

        try {
            call_user_func_array([$this->airWaybills, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(TrackingMoreException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }

}