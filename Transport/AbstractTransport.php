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

namespace Plemi\Bundle\PayboxBundle\Transport;

/**
 * Transport base which contains the main methods for transports.
 *
 * @author Erwann Mest <erwann.mest@plemi.org>
 * @author Ludovic Fleury <ludovic.fleruy@plemi.org>
 */
abstract class AbstractTransport
{
    /**
     * This is what the transport will point. Can be an url or a path (depends
     * what transport you use, cURL or Shell)
     *
     * @var string $endpoint Url or Path
     */
    protected $endpoint;

    /**
     * Construct the object
     *
     * @param string $endpoint to paybox endpoint
     */
    public function __construct($endpoint = '')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Define the endpoint. It can be an url or a path, depends what control you
     * choose.
     *
     * @param string $endpoint to paybox endpoint
     */
    public function setEndpoint($endpoint)
    {
        if (!is_string($endpoint)) {
            throw new \InvalidArgumentException('$endpoint must be a string.');
        }

        $this->endpoint = $endpoint;
    }

    /**
     * Get the paybox endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Perform a call
     * 
     * @throws RunTimeException If no endpoint defined
     */
    protected function checkEndpoint()
    {
        if ($this->endpoint == '' || null === $this->endpoint || empty($this->endpoint)) {
            throw new \RunTimeException('No endpoint defined.');
        }
    }
}
