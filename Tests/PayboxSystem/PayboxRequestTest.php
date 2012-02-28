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

use Plemi\Bundle\PayboxBundle\PayboxSystem\PayboxRequest;
use Plemi\Bundle\PayboxBundle\Transport\TransportInterface;
use Plemi\Bundle\PayboxBundle\Transport\CurlTransport;
use Plemi\Bundle\PayboxBundle\Transport\ShellTransport;

/**
 * Test class for PayboxRequest.
 */
class PayboxRequestTest extends \PHPUnit_Framework_TestCase
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
        $this->object = new PayboxRequest();
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
        $this->assertTrue(count($this->object->getDatas()) == 0);
    }

    public function testSetDatas()
    {
        $array = array(
                'pbx_retour' => 'test',
                'pbx_rang' => '233'
        );
        $this->object->setDatas($array);
        $datas = $this->object->getDatas();

        $this->assertTrue(count($this->object->getDatas()) == 2);

        $array = array(
                'pbx_effectue' => 'test',
                'pbx_refuse' => '233'
        );
        $this->object->setDatas($array);

        $this->assertTrue(count($this->object->getDatas()) == 4);

        $array = array(
                'pbx_effectue' => 'test',
                'pbx_bin6' => '233'
        );
        $this->object->setDatas($array);

        $this->assertTrue(count($this->object->getDatas()) == 5);
    }

    public function testGetEmptyData()
    {
        $data = $this->object->getData('pbx_retour');
        $this->assertTrue(is_string($data));
        $this->assertEquals($data, '');
    }

    public function testGetData()
    {
        $this->object->setData('pbx_retour', 'test');
        $data = $this->object->getData('pbx_retour');
        $this->assertTrue(is_string($data));
    }

    public function testSetData()
    {
        $this->object->setData('pbx_retour', 'test');
        $this->assertAttributeEquals(array('PBX_RETOUR' => 'test'), 'datas', $this->object);
    }

    public function testSetSite()
    {
        $this->object->setSite('test');
        $this->assertAttributeEquals(array('PBX_SITE' => 'test'), 'datas', $this->object);
    }

    public function testSetRank()
    {
        $this->object->setRank('test');
        $this->assertAttributeEquals(array('PBX_RANG' => 'test'), 'datas', $this->object);
    }

    public function testSetIdentifier()
    {
        $this->object->setIdentifier('test');
        $this->assertAttributeEquals(array('PBX_IDENTIFIANT' => 'test'), 'datas', $this->object);
    }

    public function testSetAmount()
    {
        $this->object->setAmount('test');
        $this->assertAttributeEquals(array('PBX_TOTAL' => 'test'), 'datas', $this->object);
    }

    public function testSetCurrency()
    {
        $this->object->setCurrency('EUR');
        $this->assertAttributeEquals(array('PBX_DEVISE' => '978'), 'datas', $this->object);

        $this->object->setCurrency('USD');
        $this->assertAttributeEquals(array('PBX_DEVISE' => '840'), 'datas', $this->object);
    }

    public function testSetOrderReference()
    {
        $this->object->setOrderReference('test');
        $this->assertAttributeEquals(array('PBX_CMD' => 'test'), 'datas', $this->object);
    }

    public function testSetPurchaserEmail()
    {
        $this->object->setPurchaserEmail('test');
        $this->assertAttributeEquals(array('PBX_PORTEUR' => 'test'), 'datas', $this->object);
    }

    public function testSetAcceptedPaymentUrl()
    {
        $this->object->setAcceptedPaymentUrl('test');
        $this->assertAttributeEquals(array('PBX_EFFECTUE' => 'test'), 'datas', $this->object);
    }

    public function testSetRefusedPaymentUrl()
    {
        $this->object->setRefusedPaymentUrl('test');
        $this->assertAttributeEquals(array('PBX_REFUSE' => 'test'), 'datas', $this->object);
    }

    public function testSetCanceledPaymentUrl()
    {
        $this->object->setCanceledPaymentUrl('test');
        $this->assertAttributeEquals(array('PBX_ANNULE' => 'test'), 'datas', $this->object);
    }

    public function testSetServerToServerCallUrl()
    {
        $this->object->setServerToServerCallUrl('test');
        $this->assertAttributeEquals(array('PBX_REPONDRE_A' => 'test'), 'datas', $this->object);
    }

    public function testSetReturnParameters()
    {
        $this->object->setReturnParameters('HELLO:HEY;R:B');
        $this->assertAttributeEquals(array('PBX_RETOUR' => 'HELLO:HEY;R:B'), 'datas', $this->object);
    }

    public function testGetTransport()
    {
        $mockPayboxRequest = new MockPayboxRequest();
        $this->assertTrue('Plemi\Bundle\PayboxBundle\Transport\CurlTransport' == get_class($mockPayboxRequest->getTransport()));
    }

    public function testSetTransport()
    {
        $transport = new CurlTransport();
        $this->object->setTransport($transport);
        $this->assertTrue('Plemi\Bundle\PayboxBundle\PayboxSystem\PayboxRequest' == get_class($this->object));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExecuteWithoutTransport()
    {
        $this->object->execute();
    }

    public function testExecute()
    {
        $datas = array('PBX_RETOUR' => 'L:L;M:M');

        $transport = new MockCurlTransport();
        $transport->setEndpoint('http://hello.fr/paybox.cgi');
        $this->object->setDatas($datas);
        $this->object->setTransport($transport);
        $this->assertTrue(is_string($this->object->execute()));
    }

}

class MockCurlTransport extends CurlTransport implements TransportInterface
{
    public function call(PayboxRequest $request)
    {
        return '';
    }

}

class MockPayboxRequestWithEmptyTransport extends PayboxRequest
{
    public function getTransport()
    {
        return parent::getTransport();
    }

}

class MockPayboxRequest extends PayboxRequest
{
    public function __construct()
    {
        $transport = new CurlTransport();
        parent::__construct($transport);
    }

    public function getTransport()
    {
        return parent::getTransport();
    }

}
