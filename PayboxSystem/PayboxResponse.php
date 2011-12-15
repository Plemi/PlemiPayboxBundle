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

/**
 * Paybox Response model
 *
 * @author Erwann MEST <erwann.mest@plemi.org>
 * @author Ludovic Fleury <ludovic.fleury@plemi.org>
 */
class PayboxResponse
{
    /**
     * Paybox Response Variables in array.
     *
     * @var array $datas
     */
    protected $datas;

    /**
     * Instanciate a reponse
     *
     */
    public function __construct()
    {
        $this->datas = array();
    }

    /**
     * Retrieve all the response's datas.
     *
     * @return array $datas
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
     * Retrieve a specific response value by key.
     *
     * @param string $key The mapped key (M, A, etc.)
     *
     * @return string This is what Paybox answered after a transaction
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
     * Retrieve the total amount of the transaction.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->datas['M'];
    }

    /**
     * Retrieve the order identifier of the transaction.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->datas['R'];
    }

    /**
     * Retrieve the transaction unique identifier.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->datas['T'];
    }

    /**
     * Retrieve the authorisation identifier of the transaction.
     *
     * @return string
     */
    public function getAuthorisationId()
    {
        return $this->datas['A'];
    }

    /**
     * Retrieve the subscription identifier.
     *
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->datas['B'];
    }

    /**
     * Retrieve the specified payment method.
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->datas['P'];
    }

    /**
     * Retrieve the credit card type used for the transaction.
     *
     * @return string
     */
    public function getCreditCardType()
    {
        return $this->datas['C'];
    }

    /**
     * Retrieve the unique transaction id.
     *
     * @return string
     */
    public function getSoleTransactionId()
    {
        return $this->datas['S'];
    }

    /**
     * Retrieve the normalized country code.
     *
     * @return string An ISO 3166-1 code
     */
    public function getCountryCode()
    {
        return $this->datas['Y'];
    }

    /**
     * Retrieve error code.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->datas['E'];
    }

    /**
     * Retrieve the expiration card date.
     *
     * @return string
     */
    public function getExpirationCardDate()
    {
        return $this->datas['D'];
    }

    /**
     * Subscription management with the PAYBOX DIRECT Plus process. Url encoded
     *
     * @return string
     */
    public function getSubscriptionManagement()
    {
        return $this->datas['U'];
    }

    /**
     * Retrieve the geolocalized IP.
     *
     * @return string
     */
    public function getIpCountryCode()
    {
        return $this->datas['I'];
    }

    /**
     * Retrieve the hashmac of the transaction.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->datas['K'];
    }

    /**
     * The first 6 digits (« bin6 ») of the cardholder
     *
     * @return string
     */
    public function getBin6()
    {
        return $this->datas['N'];
    }

    /**
     * This is Digest (patch this comment if you get more informations from the
     * doc)
     *
     * @return string
     */
    public function getDigest()
    {
        return $this->datas['H'];
    }

    /**
     * Retrieve the guarantee applicable to the payment.
     *
     * @return string
     */
    public function getPaymentGuaranteed()
    {
        return $this->datas['G'];
    }

    /**
     * State of the enrolment of the cardholder. Y:Authentification available,
     * N:Cardholder not participating, U:Unable to authenticate
     *
     * @return string
     */
    public function getEnrolment()
    {
        return $this->datas['O'];
    }

    /**
     * Retrieve the auth status.
     *
     * @return string
     */
    public function getAuthenticationStatus()
    {
        return $this->datas['F'];
    }

    /**
     * Retrieve the 4 last numbers of the card.
     *
     * @return string
     */
    public function getLastPanDigits()
    {
        return $this->datas['J'];
    }

    /**
     * Retrieve the date of the transaction.
     *
     * @return string
     */
    public function getTransactionDate()
    {
        return $this->datas['W'];
    }

    /**
     * Retrieve the gift index.
     *
     * @return string
     */
    public function getGiftIndex()
    {
        return $this->datas['Z'];
    }

    /**
     * Retrieve the transaction time.
     *
     * @return string
     */
    public function getTransactionTime()
    {
        return $this->datas['Q'];
    }

}
