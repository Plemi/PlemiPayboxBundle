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

use Plemi\Bundle\PayboxBundle\PayboxSystem\PayboxRequest;

/**
 * Perform a call with cURL
 *
 * @author David Guyon <david.guyon@plemi.org>
 * @author Erwann Mest <erwann.mest@plemi.org>
 * @author Ludovic Fleury <ludovic.fleury@plemi.org>
 */
class CurlTransport extends AbstractTransport implements TransportInterface
{
    /**
     * Constructor
     *
     * @throws RuntimeException If cURL is not available
     */
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('cURL is not available. Activate it first.');
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param PayboxRequest $request Request instance
     *
     * @throws RuntimeException On cURL error
     *
     * @return string $response The html of the temporary form
     */
    public function call(PayboxRequest $request)
    {
        $this->checkEndpoint();

        $datas = $request->checkAndGetDatas();
        $datas['PBX_MODE'] = 1;

        $ch = curl_init();

        // cURL options
        $options = array(
                CURLOPT_URL => $this->getEndpoint(),
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($datas)
        );
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        $curlErrorNumber = curl_errno($ch);
        $curlErrorMessage = curl_error($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!in_array($responseCode, array(0, 200, 201, 204))) {
            throw new \RuntimeException('cUrl returns some errors (cURL errno '.$curlErrorNumber.'): '.$curlErrorMessage.' (HTTP Code: '.$responseCode.')');
        }

        curl_close($ch);

        return $response;
    }

}
