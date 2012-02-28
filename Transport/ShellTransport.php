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
 * Perform a call with shell exec
 *
 * @author David Guyon <david.guyon@plemi.org>
 * @author Erwann Mest <erwann.mest@plemi.org>
 * @author Ludovic Fleury <ludovic.fleury@plemi.org>
 */
class ShellTransport extends AbstractTransport implements TransportInterface
{
    /**
     * Ensure endpoint validity.
     *
     * @throws RuntimeException If the endpoint is not a valid filepath
     */
    protected function checkEndpoint()
    {
        parent::checkEndpoint();

        if (!is_file($this->getEndpoint())) {
            throw new \RuntimeException("The file '$this->endpoint' doesn't exist.");
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param PayboxRequest $request Request instance
     *
     * @return string $response The html of the temporary form
     */
    public function call(PayboxRequest $request)
    {
        $this->checkEndpoint();

        $datas = $request->checkAndGetDatas();
        $datas['PBX_MODE'] = 4;

        $cmd = sprintf('%s %s', escapeshellarg($this->getEndpoint()), $this->formatParameters($datas));
        $response = shell_exec($cmd);

        return $response;
    }

    private function formatParameters(array $datas)
    {
        $parameters = array();
        foreach($datas as $key => $value) {
            $parameters[] = sprintf('%s=%s', $key, escapeshellarg($value));
        }

        return implode(' ', $parameters);
    }
}
