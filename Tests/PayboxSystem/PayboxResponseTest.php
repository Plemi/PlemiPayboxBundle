<?php

/*
 * This file is part of the PlemiPayboxBundle.
 *
 * (c) Ludovic Fleury <ludovic.fleury@plemi.org>
 * (c) David Guyon <david.guyon@plemi.org>
 * (c) Erwann Mest <erwann.mest@plemi.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Plemi\Bundle\PayboxBundle\Tests\PayboxSystem;

use Plemi\Bundle\PayboxBundle\PayboxSystem\PayboxResponse;

/**
 * Test class for PayboxRequest.
 */
class PayboxResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PayboxRequest
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new PayboxResponse();
    }

    /**
     * Clean the object
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    public function testGetDatas()
    {
        $this->assertTrue(is_array($this->object->getDatas()));
    }

    public function testSetDatas()
    {
        $array = array(
                'pbx_retour' => 'test',
                'pbx_rang' => '233'
        );
        $this->object->setDatas($array);
        $this->assertAttributeEquals($array, 'datas', $this->object);
    }

    public function testGetData()
    {
        $this->object->setData('M', 'test');
        $data = $this->object->getData('M');
        $this->assertTrue(is_string($data));
    }

    public function testSetEmptyData()
    {
        $data = $this->object->getData('M');
        $this->assertTrue(is_string($data));
        $this->assertEquals($data, '');
    }

    public function testSetData()
    {
        $this->object->setData('M', 'test');
        $data = $this->object->getData('M');
        $datas = $this->object->getDatas();
        $this->assertTrue(is_string($data));
        $this->assertTrue(is_array($datas));
    }

    public function testGetAmount()
    {
        $this->object->setData('M', 'test');
        $data = $this->object->getAmount();
        $this->assertEquals($data, 'test');
    }

    public function testGetOrderId()
    {
        $this->object->setData('R', 'test');
        $data = $this->object->getOrderId();
        $this->assertEquals($data, 'test');
    }

    public function testGetTransactionId()
    {
        $this->object->setData('T', 'test');
        $data = $this->object->getTransactionId();
        $this->assertEquals($data, 'test');
    }

    public function testGetAuthorisationId()
    {
        $this->object->setData('A', 'test');
        $data = $this->object->getAuthorisationId();
        $this->assertEquals($data, 'test');
    }

    public function testGetSubscriptionId()
    {
        $this->object->setData('B', 'test');
        $data = $this->object->getSubscriptionId();
        $this->assertEquals($data, 'test');
    }

    public function testGetPaymentMethod()
    {
        $this->object->setData('P', 'test');
        $data = $this->object->getPaymentMethod();
        $this->assertEquals($data, 'test');
    }

    public function testGetCreditCardType()
    {
        $this->object->setData('C', 'test');
        $data = $this->object->getCreditCardType();
        $this->assertEquals($data, 'test');
    }

    public function testGetSoleTransactionId()
    {
        $this->object->setData('S', 'test');
        $data = $this->object->getSoleTransactionId();
        $this->assertEquals($data, 'test');
    }

    public function testGetCountryCode()
    {
        $this->object->setData('Y', 'test');
        $data = $this->object->getCountryCode();
        $this->assertEquals($data, 'test');
    }

    public function testGetErrorCode()
    {
        $this->object->setData('E', 'test');
        $data = $this->object->getErrorCode();
        $this->assertEquals($data, 'test');
    }

    public function testGetExpirationCardDate()
    {
        $this->object->setData('D', 'test');
        $data = $this->object->getExpirationCardDate();
        $this->assertEquals($data, 'test');
    }

    public function testGetSubscriptionManagement()
    {
        $this->object->setData('U', 'test');
        $data = $this->object->getSubscriptionManagement();
        $this->assertEquals($data, 'test');
    }

    public function testGetIpCountryCode()
    {
        $this->object->setData('I', 'test');
        $data = $this->object->getIpCountryCode();
        $this->assertEquals($data, 'test');
    }

    public function testGetSignature()
    {
        $this->object->setData('K', 'test');
        $data = $this->object->getSignature();
        $this->assertEquals($data, 'test');
    }

    public function testGetBin6()
    {
        $this->object->setData('N', 'test');
        $data = $this->object->getBin6();
        $this->assertEquals($data, 'test');
    }

    public function testGetDigest()
    {
        $this->object->setData('H', 'test');
        $data = $this->object->getDigest();
        $this->assertEquals($data, 'test');
    }

    public function testGetPaymentGuaranteed()
    {
        $this->object->setData('G', 'test');
        $data = $this->object->getPaymentGuaranteed();
        $this->assertEquals($data, 'test');
    }

    public function testGetEnrolment()
    {
        $this->object->setData('O', 'test');
        $data = $this->object->getEnrolment();
        $this->assertEquals($data, 'test');
    }

    public function testGetAuthenticationStatus()
    {
        $this->object->setData('F', 'test');
        $data = $this->object->getAuthenticationStatus();
        $this->assertEquals($data, 'test');
    }

    public function testGetLastPanDigits()
    {
        $this->object->setData('J', 'test');
        $data = $this->object->getLastPanDigits();
        $this->assertEquals($data, 'test');
    }

    public function testGetTransactionDate()
    {
        $this->object->setData('W', 'test');
        $data = $this->object->getTransactionDate();
        $this->assertEquals($data, 'test');
    }

    public function testGetGiftIndex()
    {
        $this->object->setData('Z', 'test');
        $data = $this->object->getGiftIndex();
        $this->assertEquals($data, 'test');
    }

    public function testGetTransactionTime()
    {
        $this->object->setData('Q', 'test');
        $data = $this->object->getTransactionTime();
        $this->assertEquals($data, 'test');
    }

}