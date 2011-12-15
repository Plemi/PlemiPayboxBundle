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

use Plemi\Bundle\PayboxBundle\Transport\TransportInterface;

/**
 * Paybox Request model
 *
 * @author Erwann MEST <erwann.mest@plemi.org>
 */
class PayboxRequest
{
    /**
     * Paybox Request Variables in array.
     *
     * @var array $datas
     */
    protected $datas;

    /**
     * @var TransportInterface This is how
     * you will point to Paybox (via cURL or Shell)
     */
    protected $transport;

    /**
     * Instanciate a request
     *
     * @param TransportInterface $transport
     * The way you'll call paybox (cURL or Shell)
     */
    public function __construct(TransportInterface $transport = null)
    {
        $this->transport = $transport;
        $this->datas = array();
    }

    /**
     * Set a transport for execute
     *
     * @param TransportInterface $transport
     * The way you'll call paybox (cURL or Shell)
     *
     * @return PayboxRequest
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Get the transport to use
     *
     * @return TransportInterface
     */
    protected function getTransport()
    {
        return $this->transport;
    }

    /**
     * Paybox workflow
     *
     * @throws RuntimeException If transport is undefined
     *
     * @return string $response This is the HTML the cgi will create.
     */
    public function execute()
    {
        $transport = $this->getTransport();

        if (!$transport instanceof TransportInterface) {
            throw new \RuntimeException('Undefined transport');
        }

        $this->formatDatas();

        $response = $transport->call($this->getDatas());

        return $response;
    }

    /**
     * Will format datas depending to the transport used
     */
    private function formatDatas()
    {
        $transportClassName = get_class($this->getTransport());

        // @TODO Remove dependencies, refactor PBX_MODE in the transport side.
        if ($transportClassName == 'Plemi\Bundle\PayboxBundle\Transport\CurlTransport') {
            $this->setData('PBX_MODE', '1');
        } elseif ($transportClassName == 'Plemi\Bundle\PayboxBundle\Transport\ShellTransport') {
            $this->setData('PBX_MODE', '4');
        }

        $this->setData('PBX_RETOUR', 'M:M;R:R;T:T;A:A;B:B;P:P;C:C;S:S;Y:Y;E:E;D:D;S:S;I:I;N:N;H:H;G:G;O:O;F:F;J:J;W:W;Z:Z;Q:Q;K:K');
    }

    /**
     * Retrieve all the request's data.
     *
     * @return array $datas Datas
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Hydrate object with an array of data.
     *
     * @param array $val An array filled with paybox data
     */
    public function setDatas(array $val)
    {
        $this->datas = array_merge($this->datas, $val);
    }

    /**
     * Retrieve a specific request value by key.
     *
     * @param string $key The mapped key (M, A, etc.)
     *
     * @return string $result Empty if the key doesn't exist
     */
    public function getData($key)
    {
        return isset($this->datas[$key]) ? $this->datas[$key] : '';
    }

    /**
     * Set a specific data by key.
     *
     * @param string $key The mapped key
     * @param string $val The value bound to the key
     */
    public function setData($key, $val)
    {
        $this->datas[$key] = $val;
    }

    /**
     * Define the site.
     *
     * @param string $val Site number
     */
    public function setSite($val)
    {
        $this->datas['PBX_SITE'] = $val;
    }

    /**
     * Define the rank.
     *
     * @param string $val Rank
     */
    public function setRank($val)
    {
        $this->datas['PBX_RANG'] = $val;
    }

    /**
     * Define the merchant identifier.
     *
     * @param string $val The unique merchant identifier.
     */
    public function setIdentifier($val)
    {
        $this->datas['PBX_IDENTIFIANT'] = $val;
    }

    /**
     * Define the total amount of the transaction.
     *
     * @param string $val The total amount
     */
    public function setAmount($val)
    {
        $this->datas['PBX_TOTAL'] = $val;
    }

    /**
     * Define currency for the transaction.
     *
     * Paybox use the numeric value of the ISO 4217.
     * This method converts the numeric value to the litteral one.
     *
     * @param string $code An ISO 4217 currency code
     */
    public function setCurrency($code)
    {
        if ($code == 'EUR') {
            $code = '978';
        } elseif ($code == 'USD') {
            $code = '840';
        }

        $this->datas['PBX_DEVISE'] = $code;
    }

    /**
     * Define the order merchant's reference.
     *
     * @param string $val The merchant order reference
     */
    public function setOrderReference($val)
    {
        $this->datas['PBX_CMD'] = $val;
    }

    /**
     * Define the customer email
     *
     * @param string $email The customer email
     */
    public function setPurchaserEmail($email)
    {
        $this->datas['PBX_PORTEUR'] = $email;
    }

    /**
     * Define the success URL.
     *
     * The customer will be redirected to this URL
     * if the transaction is successfull.
     *
     * @param string $url An absolute URL
     */
    public function setAcceptedPaymentUrl($url)
    {
        $this->datas['PBX_EFFECTUE'] = $url;
    }

    /**
     * Define the error URL.
     *
     * The customer will be redirected to this URL
     * if any error happend during the transaction process.
     *
     * @param string $url An absolute URL
     */
    public function setRefusedPaymentUrl($url)
    {
        $this->datas['PBX_REFUSE'] = $url;
    }

    /**
     * Define the cancel URL.
     *
     * If the customer abort the transaction flow
     * he will be redirected to this URL
     *
     * @param string $url An absolute URL
     */
    public function setCanceledPaymentUrl($url)
    {
        $this->datas['PBX_ANNULE'] = $url;
    }

    /**
     * Define the callback URL.
     *
     * Paybox will notify the transaction status to this URL
     *
     * @param string $url An absolute URL
     */
    public function setServerToServerCallUrl($url)
    {
        $this->datas['PBX_REPONDRE_A'] = $url;
    }

    /**
     * Define return parameters for Paybox Response
     *
     * @param string $param See the paybox doc to know what exactly to specify
     * here
     */
    public function setReturnParameters($param)
    {
        $this->datas['PBX_RETOUR'] = $param;
    }

}
