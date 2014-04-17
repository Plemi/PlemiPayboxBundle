<?php

namespace Plemi\Bundle\PayboxBundle\PayboxSystem;

use Plemi\Bundle\PayboxBundle\PayboxSystem\PayboxManager;

/**
 * Creates paybox request when using multiple payboxes.
 */
class PayboxRequestFactory
{
    /**
     * @var PayboxManager
     */
    private $manager;

    /**
     * @var array
     */
    private $boxes;

    /**
     * Constructor.
     *
     * @param PayboxManager $manager
     * @param array         $boxes
     */
    public function __construct(PayboxManager $manager, array $boxes)
    {
        $this->manager = $manager;
        $this->boxes   = $boxes;
    }

    /**
     * Creates a new paybox request.
     *
     * @param string $box  The box name
     * @param array  $data Additional data to set on the request
     *
     * @return PayboxRequest
     */
    public function createRequest($box = 'default', array $data = array())
    {
        if (!array_key_exists($box, $this->boxes)) {
            throw new \InvalidArgumentException(sprintf('There is no box named "%s".', $box));
        }

        $data = array_merge($this->boxes[$box]['datas'], $data);
        $request = $this->manager->createRequest($data);

        return $request;
    }
}
