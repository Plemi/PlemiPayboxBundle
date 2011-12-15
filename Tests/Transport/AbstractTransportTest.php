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

use Plemi\Bundle\PayboxBundle\Transport\AbstractTransport;

/**
 * Test class for Abstract Transport
 */
class AbstractTransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractTransport
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new MockTransport();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionSetEndpoint()
    {
        $this->object->setEndpoint(3243204);
    }

    public function testSetEndpoint()
    {
        $this->object->setEndpoint('http://www.hello.fr/hey.cgi');

        // This is how to test a private or protected attribute. Value expected,
        // Attribute name, Object
        $this->assertAttributeEquals('http://www.hello.fr/hey.cgi', 'endpoint', $this->object);
    }

    public function testGetEndpoint()
    {
        $this->object->setEndpoint('http://www.hello.fr/hey.cgi');
        $this->assertTrue(is_string($this->object->getEndpoint()));
        $this->assertEquals('http://www.hello.fr/hey.cgi', $this->object->getEndpoint());
    }

    /**
     * @expectedException \RunTimeException
     */
    public function testCheckEndpoint()
    {
        $method = new \ReflectionMethod('\Plemi\Bundle\PayboxBundle\Transport\AbstractTransport', 'checkEndpoint');
        $method->setAccessible(TRUE);
        $method->invoke($this->object);
    }

}

class MockTransport extends AbstractTransport
{
    public function call(array $datas)
    {

    }

}
