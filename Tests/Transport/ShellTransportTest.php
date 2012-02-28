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

use Plemi\Bundle\PayboxBundle\Transport\ShellTransport;

/**
 * Test class for ShellTransport
 */
class ShellTransportTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->object = new ShellTransport();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCallWithNonExistentEndpoint()
    {
        $this->object->setEndpoint('/hello/world/hey.cgi');
        $method = new \ReflectionMethod('\Plemi\Bundle\PayboxBundle\Transport\ShellTransport', 'call');
        $method->setAccessible(TRUE);
        $response = $method->invoke($this->object, array('CBX_RANG' => '2'));
    }

    public function testFormatParameters()
    {
        $method = new \ReflectionMethod('\Plemi\Bundle\PayboxBundle\Transport\ShellTransport', 'formatParameters');
        $method->setAccessible(TRUE);
        $params = $method->invoke($this->object, array('PBX_RANG' => '2', 'PBX_PAYBOX' => 'test'));
        $this->assertInternalType('string', $params);
        $this->assertEquals("PBX_RANG='2' PBX_PAYBOX='test'", $params, 'binary arguments are escaped, contain the key and are space separated');
    }

    public function testCallEmpty()
    {
        $shell = new mockShellTransport();
        $this->assertEquals($shell->call(array()), '');
    }
}

class mockShellTransport extends ShellTransport
{

    public function call(array $datas)
    {
        return '';
    }

}
