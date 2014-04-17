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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for Paybox bundle
 *
 * @author David Guyon <david.guyon@plemi.org>
 * @author Erwann MEST <erwann.mest@plemi.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('plemi_paybox');

        $rootNode
            ->beforeNormalization()
                ->ifTrue(function ($v) { return array_key_exists('datas', $v); })
                ->then(function ($v) {
                    $v['boxes'] = array(
                        'default' => array(
                            'datas' => $v['datas'],
                        ),
                    );

                    return $v;
                })
            ->end()
            ->beforeNormalization()
                ->ifTrue(function ($v) { return array_key_exists('boxes', $v) && !array_key_exists('default', $v['boxes']); })
                ->then(function ($v) {
                    $v['boxes']['default'] = array(
                        'datas' => array(),
                    );

                    return $v;
                })
            ->end()
            ->children()
                ->scalarNode('transport')
                    ->defaultValue('shell')
                ->end()
                ->scalarNode('endpoint')
                    ->defaultValue('%kernel.root_dir%/Resources/cgi-bin/paybox.cgi')
                ->end()
                ->arrayNode('datas')
                    ->useAttributeAsKey(0)
                    ->prototype('variable')->end()
                ->end()
                ->arrayNode('boxes')
                    ->defaultValue(array('default' => array('datas' => array())))
                    ->prototype('array')
                        ->children()
                            ->arrayNode('datas')
                                ->prototype('variable')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}
