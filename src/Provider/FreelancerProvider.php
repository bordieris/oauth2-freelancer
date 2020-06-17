<?php

namespace Bordieris\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class FreelancerProvider extends AbstractProvider
{
    /**
     * Returns authorization headers for the 'bearer' grant.
     *
     * @param  AccessTokenInterface|string|null $token Either a string or an access token instance
     * @return array
     */
    protected function getAuthorizationHeaders($token = null)
    {
        return ['freelancer-oauth-v1:' =>  $token];
    }

    public function getBaseAuthorizationUrl()
    {
        return 'https://accounts.freelancer.com/oauth/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://accounts.freelancer.com/oauth/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://www.freelancer.com/api/users/0.1/self/';
    }

    protected function getDefaultScopes()
    {
        return ['basic'];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                $data['error'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response->getBody()
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new FreelancerResourceOwner($response);
    }

    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * @inheritdoc
     * @throws IdentityProviderException
     */
    protected function parseResponse(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode > 500) {
            throw new IdentityProviderException(
                'The OAuth server returned an unexpected response',
                $statusCode,
                $response->getBody()
            );
        }

        return parent::parseResponse($response);
    }
}
