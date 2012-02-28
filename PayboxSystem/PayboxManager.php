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

namespace Plemi\Bundle\PayboxBundle\PayboxSystem;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paybox manager class
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class PayboxManager
{
    private $container;

    /**
     * Initializes Paybox manager.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Creates PayboxRequest instance.
     *
     * @param array $data optional PBX_ values
     *
     * @return PayboxRequest
     */
    public function createRequest(array $data = array())
    {
        $request = $this->container->get('plemi_paybox.request');
        $request->setDatas($data);

        return $request;
    }

    /**
     * Creates PayboxResponse instance from Symfony request.
     *
     * @param Request $request request
     *
     * @return PayboxResponse
     */
    public function createResponse(Request $request)
    {
        $response = $this->container->get('plemi_paybox.response');
        $response->setDatas($request->query->all());

        return $response;
    }
}
