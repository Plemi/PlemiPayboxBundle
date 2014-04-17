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

namespace Plemi\Bundle\PayboxBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

/**
 * Service container definition for Paybox bundle
 *
 * @author David Guyon <david.guyon@plemi.org>
 * @author Erwann MEST <erwann.mest@plemi.org>
 */
class PlemiPayboxExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @param array            $configs   Configuration to load
     * @param ContainerBuilder $container Container of the bundle
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        if (empty($config['endpoint'])) {
            throw new \InvalidArgumentException('The "endpoint" option must be set in order to use "plemi_paybox" service');
        }
        $container->setParameter('plemi_paybox.endpoint', $config['endpoint']);
        $container->setParameter('plemi_paybox.datas', $config['boxes']['default']['datas']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('transport/'.$config['transport'].'.xml');
        $loader->load('paybox.xml');
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getAlias()
    {
        return 'plemi_paybox';
    }
}
