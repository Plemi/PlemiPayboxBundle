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
 * This is what Transport classes must have.
 *
 * @author David Guyon <david.guyon@plemi.org>
 * @author Erwann Mest <erwann.mest@plemi.org>
 * @author Ludovic Fleury <ludovic.fleury@plemi.org>
 */
interface TransportInterface
{
    /**
     * Prepare and send a message.
     * 
     * @param array $datas Datas which will be sent to Paybox
     *
     * @return string The Paybox response
     */
    public function call(array $datas);
}
