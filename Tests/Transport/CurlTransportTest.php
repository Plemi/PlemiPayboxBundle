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

namespace Plemi\Bundle\PayboxBundle\Tests\Transport;

use Plemi\Bundle\PayboxBundle\Transport\CurlTransport;

/**
 * Test class for CurlTransport
 */
class CurlTransportTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        if (!function_exists('curl_init')) {
            $this->markTestSkipped('cURL is not available. Activate it first.');
        }

        $this->object = new CurlTransport();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCall()
    {
        $this->object->setEndpoint('http://test.fr/hey.cgi');
        $method = new \ReflectionMethod('\Plemi\Bundle\PayboxBundle\Transport\CurlTransport', 'call');
        $method->setAccessible(TRUE);
        $response = $method->invoke($this->object, array());
        $this->assertTrue(is_string($response));
    }

    public function testCallEmpty()
    {
        $curl = new mockCurlTransport();
        $this->assertEquals($curl->call(array()), '');
    }

}

class mockCurlTransport extends CurlTransport
{

    public function call(array $datas)
    {
        return '';
    }

}
