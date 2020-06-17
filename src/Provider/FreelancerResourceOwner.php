<?php

namespace Bordieris\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class FreelancerResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response['result'];
    }

    /**
     * Returns the uuid of the authorized resource owner
     *
     * @return string
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getName()
    {
        return $this->getValueByKey($this->response, 'username');
    }

    /**
     * Returns the country name
     *
     * @return string
     */
    public function getCountryName()
    {
        $location = $this->getValueByKey($this->response, 'location');
        $country = $this->getValueByKey($location, 'country');
        return $this->getValueByKey($country, 'name');
    }

    /**
     * Returns the user's "role"
     * Known values are:
     *  - freelancer
     *  - employer
     *
     * @return string
     */
    public function getRole()
    {
        return $this->getValueByKey($this->response, 'role');
    }

    public function toArray()
    {
        return $this->response;
    }
}
