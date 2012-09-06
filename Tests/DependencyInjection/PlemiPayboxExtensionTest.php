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

namespace Plemi\Bundle\PayboxBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Plemi\Bundle\PayboxBundle\DependencyInjection\PlemiPayboxExtension;

/**
 * Dependency Injection test
 */
class PlemiPayboxExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $container;
    private $extension;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new PlemiPayboxExtension();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown()
    {
        unset($this->container, $this->extension);
    }

    /**
     * Default configuration
     */
    public function testConfigurationDefault()
    {
        $this->extension->load(array( array()), $this->container);
        $this->assertEquals('%kernel.root_dir%/Resources/cgi-bin/paybox.cgi', $this->container->getParameter('plemi_paybox.endpoint'));
    }

    /**
     * Configuration with real data
     */
    public function testConfigurationWithRealData()
    {
        $this->extension->load(array( array('endpoint' => '%kernel.root_dir%/Resources/cgi-bin/paybox.cgi')), $this->container);
        $this->assertEquals('%kernel.root_dir%/Resources/cgi-bin/paybox.cgi', $this->container->getParameter('plemi_paybox.endpoint'));
    }

    /**
     *
     * @expectedException InvalidArgumentException
     */
    public function testConfigurationWithEmpty()
    {
        $this->extension->load(array( array('endpoint' => '')), $this->container);
    }

    public function testGetAlias()
    {
        $this->assertEquals($this->extension->getAlias(), 'plemi_paybox');
    }

}
